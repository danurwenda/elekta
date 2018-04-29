<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainmediaController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\GplusController;
use App\Http\Controllers\FacebookController;

class CumulativeController extends Controller {

    public static function getAllToday($id) {
        $news = MainmediaController::getToday($id);
        $twitter = TwitterController::getToday($id);
        $youtube = YoutubeController::getToday($id);
        $facebook = FacebookController::getToday($id);
        $gplus = GplusController::getToday($id);
        $all = $news + $twitter + $youtube + $facebook + $gplus;

        return $all;
    }

    public static function getAllYesterday($id) {
        $news = MainmediaController::getYesterday($id);
        $twitter = TwitterController::getYesterday($id);
        $youtube = YoutubeController::getYesterday($id);
        $facebook = FacebookController::getYesterday($id);
        $gplus = GplusController::getYesterday($id);
        $all = $news + $twitter + $youtube + $facebook + $gplus;

        return $all;
    }

    public static function getAllWeeks() {

        $news = MainmediaController::getWeeks();
        $news = json_decode($news, TRUE);
        $twitter = TwitterController::getWeeks();
        $twitter = json_decode($twitter, TRUE);
        $youtube = YoutubeController::getWeeks();
        $youtube = json_decode($youtube, TRUE);
        $gplus = GplusController::getWeeks();
        $gplus = json_decode($gplus, TRUE);

        $array = [];
        for ($i = 6; $i >= 0; $i--) {
            $new = [];
            $new['date'] = \Carbon\Carbon::now(config('app.timezone'))->subDays($i)->toDateString();
            $new['khofifah'] = 0;
            $new['ipul'] = 0;
            $new['emil'] = 0;
            $new['puti'] = 0;

            foreach ($twitter as $data) {

                if ($data['date'] == $new['date']) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    $new['emil'] += $data['emil'];
                    $new['puti'] += $data['puti'];
                    break;
                }
            }

            foreach ($news as $data) {

                if ($data['date'] == $new['date']) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    $new['emil'] += $data['emil'];
                    $new['puti'] += $data['puti'];
                    break;
                }
            }

            foreach ($youtube as $data) {

                if ($data['date'] == $new['date']) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    $new['emil'] += $data['emil'];
                    $new['puti'] += $data['puti'];
                    break;
                }
            }

            foreach ($gplus as $data) {

                if ($data['date'] == $new['date']) {
                    $new['khofifah'] += $data['khofifah'];
                    $new['ipul'] += $data['ipul'];
                    $new['emil'] += $data['emil'];
                    $new['puti'] += $data['puti'];
                    break;
                }
            }

            array_push($array, $new);
        }


        return json_encode($array);
    }

}
