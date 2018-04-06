<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Twitter;

class fetchtwitter extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:twitter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'fetch twitter data';

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
        $json = Twitter::getSearch(['q' => '@khofifahip', 'result_type' => 'recent', 'count' => 100, 'format' => 'json']);
        $json = json_decode($json, TRUE);

        foreach ($json['statuses'] as $data) {

            $new = [];
            $new['create_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            $new['id'] = $data['id_str'];
            $new['text'] = $data['text'];
            $new['user'] = $data['user'];
            $new['entities'] = $data['entities'];
            $new['retweet_count'] = $data['retweet_count'];
            $new['favorite_count'] = $data['favorite_count'];
            \DB::connection('mongodb')->collection('twitterkhofifah')->where('id', $new['id'])->update($new, ['upsert' => true]);
        }



        $json = Twitter::getSearch(['q' => '@gusipul4', 'result_type' => 'recent', 'count' => 100, 'format' => 'json']);
        $json = json_decode($json, TRUE);

        foreach ($json['statuses'] as $data) {

            $new = [];
            $new['create_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            $new['id'] = $data['id_str'];
            $new['text'] = $data['text'];
            $new['user'] = $data['user'];
            $new['entities'] = $data['entities'];
            $new['retweet_count'] = $data['retweet_count'];
            $new['favorite_count'] = $data['favorite_count'];
            \DB::connection('mongodb')->collection('twittergusipul')->where('id', $new['id'])->update($new, ['upsert' => true]);
        }

        $json = Twitter::getSearch(['q' => '@EmilDardak', 'result_type' => 'recent', 'count' => 100, 'format' => 'json']);
        $json = json_decode($json, TRUE);

        foreach ($json['statuses'] as $data) {

            $new = [];
            $new['create_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            $new['id'] = $data['id_str'];
            $new['text'] = $data['text'];
            $new['user'] = $data['user'];
            $new['entities'] = $data['entities'];
            $new['retweet_count'] = $data['retweet_count'];
            $new['favorite_count'] = $data['favorite_count'];
            \DB::connection('mongodb')->collection('twitteremil')->where('id', $new['id'])->update($new, ['upsert' => true]);
        }



        $json = Twitter::getSearch(['q' => '@GunturPuti', 'result_type' => 'recent', 'count' => 100, 'format' => 'json']);
        $json = json_decode($json, TRUE);

        foreach ($json['statuses'] as $data) {

            $new = [];
            $new['create_at'] = date("Y-m-d H:i:s", strtotime($data['created_at']));
            $new['id'] = $data['id_str'];
            $new['text'] = $data['text'];
            $new['user'] = $data['user'];
            $new['entities'] = $data['entities'];
            $new['retweet_count'] = $data['retweet_count'];
            $new['favorite_count'] = $data['favorite_count'];
            \DB::connection('mongodb')->collection('twitterputi')->where('id', $new['id'])->update($new, ['upsert' => true]);
        }

        $this->info('Success!');
    }

}
