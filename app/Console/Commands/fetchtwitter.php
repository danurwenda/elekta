<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Twitter\UserInfo;
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
        foreach (config('twitter.parties') as $user) {
            $account = UserInfo::getInfo($user['screen_name']);
            if (is_null($account)) {
                // data not available, insert into db
                $account = $this->initInfo($user['screen_name']);
                $since_id = null;
            } else {
                $since_id = $account->since_id;
            }
            $this->fetchTweet($account, $since_id);
        }
    }

    private function initInfo($screen_name) {
        $info = Twitter::getUsers(['screen_name' => $screen_name]);
//        print_r($info);
        $keys = ['id', 'name', 'screen_name', 'followers_count'];
        $arr = [];
        foreach ($keys as $key) {
            $arr[$key] = $info->$key;
        }
        return UserInfo::create($arr);
    }

    /**
     * Fetch all tweet that is newer than post with specified since_id
     * @param type account user's twitter handler
     * @param type $since_id the latest id of tweet from user_id that has been processed
     */
    private function fetchTweet($account, $since_id) {
        $account->last_fetch = time();
        $screen_name = $account->screen_name;
        $query = ['q' => '@' . $screen_name, 'result_type' => 'recent', 'count' => 100, 'format' => 'json'];
        if (isset($since_id)) {
            //fetch until we hit $since_id
            $query['since_id'] = $since_id;
            while (count($statuses = json_decode(Twitter::getSearch($query), true)['statuses']) > 0) {
                foreach ($statuses as $data) {
                    if (!isset($new_since) && isset($data['id'])) {
                        $new_since = $data['id'];
                    }
                    $this->saveTweet($data, $screen_name);
                }
                $query['max_id'] = $data['id'] - 1;
                set_time_limit(15);
            }
        } else {
            //fetch until Twitter says no
            while (count($statuses = json_decode(Twitter::getSearch($query), true)['statuses']) > 0) {
                foreach ($statuses as $data) {
                    if (!isset($new_since) && isset($data['id'])) {
                        $new_since = $data['id'];
                    }
                    $this->saveTweet($data, $screen_name);
                }
                $query['max_id'] = $data['id'] - 1;
                set_time_limit(15);
            }
        }
        if (isset($new_since)) {
            $account->since_id = $new_since;
        }
        $account->save();
        //first fetch
        $this->info('fetching ' . $screen_name . ' since ' . $since_id);
    }

    private function saveTweet($data, $screen_name) {
        $new = [];
        $new['create_at'] = new \MongoDB\BSON\UTCDateTime(strtotime($data['created_at']) * 1000);
        $new['id'] = $data['id'];
        $new['text'] = $data['text'];
        $new['user'] = $data['user'];
        $new['entities'] = $data['entities'];
        $new['retweet_count'] = $data['retweet_count'];
        $new['favorite_count'] = $data['favorite_count'];
        \DB::connection('mongodb')->collection('twitter' . $screen_name)->where('id', $new['id'])->update($new, ['upsert' => true]);
    }

}
