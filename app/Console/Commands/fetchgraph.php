<?php

namespace App\Console\Commands;

use App\Models\Twitter\Emil;
use App\Models\Twitter\Ipul;
use App\Models\Twitter\Khofifah;
use App\Models\Twitter\Puti;
use Carbon\Carbon;
use Illuminate\Console\Command;

class fetchgraph extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:graph';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Graph SAve';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        foreach (config('twitter.parties') as $id => $val) {
            switch ($id) {
                case 'khofifah':$model = Khofifah::class;
                    break;
                case 'gusipul':$model = Ipul::class;
                    break;
                case 'emil':$model = Emil::class;
                    break;
                case 'puti':$model = Puti::class;
                    break;
                default:
                    $this->error('Associated model not found for given id : ' . $id);
            }
            $this->createGraph($id, $val['screen_name'], $val['color'], $model);
        }
    }

    private function graphAggregate($collection, $today, $tomorrow) {
        return $collection->aggregate([
                    [
                        '$match' => [
                            'create_at' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $today->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $tomorrow->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'username' => '$user.screen_name'
                            ],
                            'count' => ['$sum' => 1]
                        ]
                    ]
        ]);
    }

    private function createGraph($id, $screen_name, $color, $model) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        $users = $model::raw(function($collection) use ($today, $tomorrow) {
                    return $this->graphAggregate($collection, $today, $tomorrow);
                });
        $node = [];
        array_push($node, [
            "id" => $screen_name,
            "label" => $screen_name,
            "color" => "rgb($color[0],$color[1],$color[2])",
            "size" => 100,
            "x" => 0,
            "y" => 0
        ]);

        $i = 1;
        $edges = [];
        foreach ($users as $data) {
            $x = rand(-1000, 1000);
            $y = rand(-500, 500);
            $r = rand(0, 255);
            $g = rand(0, 255);
            $b = rand(0, 255);
            array_push($node, [
                "id" => "@" . $data['_id']['username'],
                "label" => "@" . $data['_id']['username'],
                "color" => "rgb(" . $r . "," . $g . "," . $b . ")",
                "size" => 50,
                "x" => $x,
                "y" => $y
            ]);
            array_push($edges, [
                "id" => "" . $i . "",
                "source" => $screen_name,
                "target" => "@" . $data['_id']['username']
            ]);
            $i += 1;
            $tweets = $model::where("user.screen_name", '=', $data['_id']['username'])->whereBetween('create_at', [$today, $tomorrow])->get();
            $j = 1;
            foreach ($tweets as $tweet) {
                array_push($node, [
                    "id" => "@" . $tweet['user']['screen_name'] . "_" . $j,
                    "label" => "Tweet: " . $tweet['text'],
                    "size" => 25,
                    "x" => $x + rand(-68, 68),
                    "y" => $y + rand(-68, 68)
                ]);
                array_push($edges, [
                    "id" => "" . $i . "",
                    "source" => "@" . $tweet['user']['screen_name'],
                    "target" => "@" . $tweet['user']['screen_name'] . "_" . $j
                ]);
                $j += 1;
                $i += 1;
            }
        }


        $json = ["nodes" => $node, "edges" => $edges];

        file_put_contents(public_path("/resource/graph/$id.json"), json_encode($json));
    }

}
