<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use File;

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
        //
        $today = \Carbon\Carbon::now()->toDateString();
        $users = \App\Gettwitterkhofifah::raw(function($collection) {
                    $today = \Carbon\Carbon::now()->toDateString();
                    return $collection->aggregate([
                                [
                                    '$match' => ['create_at' => ['$regex' => $today . '.*', '$options' => 'g']]
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
                });
        $node = [];
        array_push($node, [
            "id" => "@khofifahip",
            "label" => "@khofifahip",
            "color" => "rgb(31,190,214)",
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
                "source" => "@khofifahip",
                "target" => "@" . $data['_id']['username']
            ]);
            $i += 1;
            $tweets = \App\Gettwitterkhofifah::where("user.screen_name", '=', $data['_id']['username'])->where('create_at', 'like', $today . '%')->get();
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

        file_put_contents(public_path('/resource/graph/khofifah.json'), json_encode($json));
        $this->info('Success1');
        $users = \App\Gettwitteripul::raw(function($collection) {
                    $today = \Carbon\Carbon::now()->toDateString();
                    return $collection->aggregate([
                                [
                                    '$match' => ['create_at' => ['$regex' => $today . '.*', '$options' => 'g']]
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
                });
        $node = [];
        array_push($node, [
            "id" => "@gusipul4",
            "label" => "@gusipul4",
            "color" => "rgb(255,0,0)",
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
                "source" => "@gusipul4",
                "target" => "@" . $data['_id']['username']
            ]);
            $i += 1;
            $tweets = \App\Gettwitteripul::where("user.screen_name", '=', $data['_id']['username'])->where('create_at', 'like', $today . '%')->get();
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

        file_put_contents(public_path('/resource/graph/gusipul.json'), json_encode($json));
        $this->info('Success2');
        $users = \App\Gettwitteremil::raw(function($collection) {
                    $today = \Carbon\Carbon::now()->toDateString();
                    return $collection->aggregate([
                                [
                                    '$match' => ['create_at' => ['$regex' => $today . '.*', '$options' => 'g']]
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
                });
        $node = [];
        array_push($node, [
            "id" => "@EmilDardak",
            "label" => "@EmilDardak",
            "color" => "rgb(0,0,255)",
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
                "source" => "@EmilDardak",
                "target" => "@" . $data['_id']['username']
            ]);
            $i += 1;
            $tweets = \App\Gettwitteremil::where("user.screen_name", '=', $data['_id']['username'])->where('create_at', 'like', $today . '%')->get();
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

        file_put_contents(public_path('/resource/graph/emil.json'), json_encode($json));
        $this->info('Success3');

        $users = \App\Gettwitterputi::raw(function($collection) {
                    $today = \Carbon\Carbon::now()->toDateString();
                    return $collection->aggregate([
                                [
                                    '$match' => ['create_at' => ['$regex' => $today . '.*', '$options' => 'g']]
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
                });
        $node = [];
        array_push($node, [
            "id" => "@GunturPuti",
            "label" => "@GunturPuti",
            "color" => "rgb(255,125,125)",
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
                "source" => "@GunturPuti",
                "target" => "@" . $data['_id']['username']
            ]);
            $i += 1;
            $tweets = \App\Gettwitterputi::where("user.screen_name", '=', $data['_id']['username'])->where('create_at', 'like', $today . '%')->get();
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

        file_put_contents(public_path('/resource/graph/puti.json'), json_encode($json));
        $this->info('Success4!');
    }

}
