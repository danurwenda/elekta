<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facebook\GroupInfo;
use App\Models\Facebook\Khofifah;
use App\Models\Facebook\Ipul;

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
            //timestamp data diambil terakhir
            'timestamp'=> GroupInfo::lastUpdate(),
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
        \Artisan::call('facebook:update', []);
        return redirect()->route('facebook');
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
