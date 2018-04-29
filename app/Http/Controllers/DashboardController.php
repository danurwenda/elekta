<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use File;

class DashboardController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.dashboard', [
            // arrays of [today,yesterday] values from each media
            'youtubekhof' => [YoutubeController::getToday(1), YoutubeController::getYesterday(1)],
            'twitterkhof' => [TwitterController::getToday(1), TwitterController::getYesterday(1)],
            'facebookkhof' => [FacebookController::getToday(1), FacebookController::getYesterday(1)],
            'mediakhof' => [MainmediaController::getToday(1), MainmediaController::getYesterday(1)],
            'gpluskhof' => [GplusController::getToday(1), GplusController::getYesterday(1)],
            'youtubeipul' => [YoutubeController::getToday(3), YoutubeController::getYesterday(3)],
            'twitteripul' => [TwitterController::getToday(3), TwitterController::getYesterday(3)],
            'facebookipul' => [FacebookController::getToday(2), FacebookController::getYesterday(2)],
            'mediaipul' => [MainmediaController::getToday(3), MainmediaController::getYesterday(3)],
            'gplusipul' => [GplusController::getToday(3), GplusController::getYesterday(3)],
            
        ]);
    }

    public static function getToday($id) {
        $today = \Carbon\Carbon::now()->toDateString();
        switch ($id) {
            case 1:
                $twitter = \App\Gettwitterkhofifah::where('create_at', 'like', $today . '%')->get()->count();
                $youtube = \App\Getyoutubekhofifah::where('snippet.publishedAt', 'like', $today . '%')->get()->count();
                $news = \App\Getkhofifah::where('published', 'like', $today . '%')->get()->count();
                break;
            case 2:
                $twitter = \App\Gettwitteripul::where('create_at', 'like', $today . '%')->get()->count();
                $youtube = \App\Getyoutubeipul::where('snippet.publishedAt', 'like', $today . '%')->get()->count();
                $news = \App\Getipul::where('published', 'like', $today . '%')->get()->count();
                break;
        }
        $today = $twitter + $youtube + $news;

        return $today;
    }

    public static function getWeeks() {
        $news = \App\Http\Controllers\MainmediaController::getWeeks();
        $news = json_decode($news, TRUE);
        $twitter = \App\Http\Controllers\TwitterController::getWeeks();
        $twitter = json_decode($twitter, TRUE);


        $array = [];
        for ($i = 6; $i >= 0; $i--) {
            $new = [];
            $new['date'] = \Carbon\Carbon::now()->subDays($i)->toDateString();
            $new['khofifah'] = 0;
            $new['ipul'] = 0;

            foreach ($twitter as $data) {

                if ($data['date'] == \Carbon\Carbon::now()->subDays($i)->toDateString()) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    break;
                }
            }

            foreach ($news as $data) {

                if ($data['date'] == \Carbon\Carbon::now()->subDays($i)->toDateString()) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    break;
                }
            }
            array_push($array, $new);
        }
        return json_encode($array);
    }

    public static function getGraph() {
        $json = File::get(public_path('/resource/graph/vote.json'));


        return $json;
    }

}
