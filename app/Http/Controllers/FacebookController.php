<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Khofifah;
use App\Models\GroupInfo;
use App\Models\Ipul;
use Facebook\Facebook;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
class FacebookController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.sosmed.facebook', [
            //data yang diambil
            //total post hari ini di masing-masing fanpage
            'totalkhof' => Khofifah::totalPostNum(),
            'totalipul' => Ipul::totalPostNum(),
            //total post per hari dalam 7 hari terakhir
            'weekkhof' => Khofifah::weeklyPostNum(),
            'weekipul' => Ipul::weeklyPostNum(),
            //total like, comment, share
            'summarykhof' => Khofifah::summary(),
            'summaryipul' => Ipul::summary(),
            //the number of follower
            'followerkhof' => Khofifah::getFollower(),
            'followeripul' => Ipul::getFollower()
        ]);
    }

    public function updateData() {
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
        return redirect()->route('facebook');
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
        echo "Done fetching from $page since $last_fetch<br/>";
    }

    public static function getYesterday($page) {
        switch ($page) {
            case 1:
                return Khofifah::getYesterday();
            case 2:
                return Ipul::getYesterday();
        }
    }

    public static function getToday($page) {
        switch ($page) {
            case 1:
                return Khofifah::getToday();
            case 2:
                return Ipul::getToday();
        }
    }

    public static function getAllPostNum($page) {
        switch ($page) {
            case 1:
                return Khofifah::totalPostNum();
            case 2:
                return Ipul::totalPostNum();
        }
    }

}
