<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\GroupInfo;
use Facebook\Facebook;

class FacebookUpdater extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching updates from Facebook pages';

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
        foreach (config('facebook.parties') as $key => $value) {
            foreach ($value['pages'] as $page) {
                $groupinfo = GroupInfo::getInfo($page);
                if (is_null($groupinfo)) {
                    // data not available, insert into db
                    $group = $this->initInfo($page);
                    $since = $group['last_fetch'];
                } else {
                    $since = $groupinfo->last_fetch;
                }
                $this->fetchPost($page, $since);
            }
        }
    }

    public function initInfo($page) {
        $fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v2.12'
        ]);
        $all_info_fields = [
            'id',
            'name',
            'about',
            'fan_count',
            'website',
            'link'];
        $all_info_fields = join(',', $all_info_fields);
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$page?fields=$all_info_fields", config('facebook.token'));
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $p = $response->getGraphPage()->asArray();
        $p['page_name'] = $page;
        $p['last_fetch'] = config('facebook.start_fetch'); // 12 Februari 2018
        GroupInfo::create($p);
        return $p;
    }

    private function fetchPost($page, $since) {
        $post_fields = [
            'likes.summary(true)',
            'comments.summary(true)',
            'created_time',
            'message',
            'id',
            'reactions',
            'shares'];
        $post_fields = join(',', $post_fields);
        $fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v2.12'
        ]);
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$page/posts?&summary=true&since=$since&fields=$post_fields", config('facebook.token'));
            // SAVE TIMESTAMP
            $groupinfo = GroupInfo::getInfo($page);
            $last_fetch = time();
            $groupinfo->last_fetch = $last_fetch;
            $groupinfo->save();
            // process response
            $postsEdge = $response->getGraphEdge();

            do {
                foreach ($postsEdge as $post) {

                    $likes_meta = $post['likes']->getMetaData();
                    $comments_meta = $post['comments']->getMetaData();
                    $pArr = $post->asArray();
                    $pArr['likes'] = ['summary' => $likes_meta['summary']];
                    $pArr['comments'] = ['summary' => $comments_meta['summary']];
                    /**
                     * INSERT $post INTO DB
                     * note that below, we use DB::collection()->insert() method
                     * instead of Eloquent::create()it forces us to explicitly 
                     * convert DateTime into ISODate
                     * which is used internally by Mongo */
                    $pArr['created_time'] = new \MongoDB\BSON\UTCDateTime($pArr['created_time']);
                    DB::collection($page)->insert($pArr);
                }
                set_time_limit(15);
            } while (
            $postsEdge = $fb->next($postsEdge)
            );
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $this->info("Done fetching from $page since $last_fetch" . PHP_EOL);
    }

}
