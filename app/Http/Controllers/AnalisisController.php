<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainmediaController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\YoutubeController;

class AnalisisController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.analisis');
    }

    public static function getPercentToday($a, $b) {
        if (($a + $b) > 0) {
            $percent = 100 * ($a / ($a + $b));
        } else {
            $percent = 0;
        }

        return number_format($percent, 2, '.', '');
        ;
    }

    public static function getPercentAllToday($id, $platform) {
        $news = MainmediaController::getToday($id);
        $twitter = TwitterController::getToday($id);
        $youtube = YoutubeController::getToday($id);

        $all = $news + $twitter + $youtube;

        switch ($platform) {
            case 1:
                $percent = 100 * ($news / $all);
                break;
            case 2:
                $percent = 100 * ($twitter / $all);
                break;
            case 3:
                $percent = 100 * ($youtube / $all);
                break;
        }

        return number_format($percent, 2, '.', '');
        ;
    }

}
