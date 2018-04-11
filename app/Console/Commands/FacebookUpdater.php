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
        $this->updateParties();
        $this->updateNews();
    }

    private function updateParties() {
        foreach (config('facebook.parties') as $value) {
            foreach ($value['pages'] as $page) {
                $groupinfo = GroupInfo::getInfo($page);
                if (is_null($groupinfo)) {
                    // data not available, insert into db
                    $group = $this->initInfo($page, config('facebook.page_collection_prefix'));
                    $since = $group['last_fetch'];
                } else {
                    $since = $groupinfo->last_fetch;
                }
                $this->fetchPost($page, $since);
            }
        }
    }

    private function updateNews() {
        foreach (config('facebook.newspages') as $id) {
            $groupinfo = GroupInfo::getInfo($id);
            if (is_null($groupinfo)) {
                // data not available, insert into db
                $group = $this->initInfo($id, config('facebook.news_collection_prefix'));
                $since = $group['last_fetch'];
            } else {
                $since = $groupinfo->last_fetch;
            }
            $this->fetchNewsPost($id, $since);
        }
    }

    private function initInfo($page, $prefix = '') {
        $fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v2.12'
        ]);
        $all_info_fields = join(',', [
            'id',
            'name',
            'about',
            'fan_count',
            'website',
            'link']);
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
        $p['collection'] = empty($prefix) ? $page : $prefix . '.' . $page;
        $p['last_fetch'] = config('facebook.start_fetch');
        GroupInfo::create($p);
        return $p;
    }

    private function fetchNewsPost($page, $since) {
        $post_fields = [
            'likes.summary(true)',
            'comments.summary(true)',
            'created_time',
            'message',
            'id',
            'shares'];
        $post_fields = join(',', $post_fields);
        $fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v2.12'
        ]);
        $groupinfo = GroupInfo::getInfo($page);
        $old_posts = DB::collection($groupinfo->collection)->get();
        // update old feed
        foreach ($old_posts as $old_post) {
            $post_id = $old_post['id'];
            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get("/$post_id?&summary=true&since=$since&fields=$post_fields", config('facebook.token'));
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $post = $response->getGraphNode();
            $pArr = $this->createPostArray($post);
            DB::collection($groupinfo->collection)
                    ->where('id', $pArr['id'])
                    ->update($pArr, ['upsert' => true]);
        }
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get("/$page/posts?&summary=true&since=$since&fields=$post_fields", config('facebook.token'));
            // SAVE TIMESTAMP
            $last_fetch = time();
            $groupinfo->last_fetch = $last_fetch;
            $groupinfo->save();
            // process response
            $postsEdge = $response->getGraphEdge();
            // new feed
            do {
                foreach ($postsEdge as $post) {
                    // check if the 'message' field contains keywords specified in config
                    $pArr = $post->asArray();
                    $keywords = config('facebook.keywords');
                    $relevant = false;
                    if (array_key_exists('message', $pArr)) {
                        while (!$relevant && (NULL != ($key = array_pop($keywords)))) {
                            $relevant = (false !== strpos($pArr['message'], $key));
                        }
                    }
                    if ($relevant) {
                        $pArr = $this->createPostArray($post);
                        DB::collection($groupinfo->collection)->insert($pArr);
                    }
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

    private function fetchPost($page, $since) {
        $post_fields = [
            'shares',
            'likes.summary(true)',
            'comments.summary(true)',
            'created_time',
            'message',
            'id'
        ];
        $post_fields = join(',', $post_fields);
        $fb = new Facebook([
            'app_id' => config('facebook.app_id'),
            'app_secret' => config('facebook.app_secret'),
            'default_graph_version' => 'v2.12'
        ]);
        $since = config('facebook.start_fetch');
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
                    $pArr = $this->createPostArray($post);
                    DB::collection($groupinfo->collection)->where('id', $pArr['id'])->update($pArr, ['upsert' => true]);
                }
                set_time_limit(30);
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

    public function createPostArray($post) {
        $likes_meta = $post['likes']->getMetaData();
        $comments_meta = $post['comments']->getMetaData();
        $pArr = $post->asArray();
        $pArr['likes'] = ['summary' => $likes_meta['summary']];
        $pArr['comments'] = ['summary' => $comments_meta['summary']];
        $pArr['interaction'] = $pArr['likes']['summary']['total_count'] + $pArr['comments']['summary']['total_count'];
        if (isset($pArr['shares']) || array_key_exists('shares', $pArr)) {
            $pArr['interaction'] += $pArr['shares']['count'];
        }
        /**
         * INSERT $post INTO DB
         * note that below, we use DB::collection()->insert() method
         * instead of Eloquent::create()it forces us to explicitly 
         * convert DateTime into ISODate
         * which is used internally by Mongo */
        $pArr['created_time'] = new \MongoDB\BSON\UTCDateTime($pArr['created_time']);
        return $pArr;
    }

}
