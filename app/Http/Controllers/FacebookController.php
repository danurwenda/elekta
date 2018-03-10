<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Khofifah;
use App\Models\GroupInfo;
use App\Models\Ipul;

/**
 * 
 */
class FacebookController extends Controller {

    public function getIndex() {
        return view('pages.sosmed.facebook', [
            //data yang diambil
            //total post hari ini di masing-masing fanpage
            'todaykhof' => Khofifah::todayPostNum(),
            'todayipul' => Ipul::todayPostNum(),
            //total post per hari dalam 7 hari terakhir
            'weekkhof'=>Khofifah::weeklyPostNum(),
            'weekipul'=>Ipul::weeklyPostNum(),
            //total like, comment, share
            'totalkhof'=>Khofifah::summary(),
            'totalipul'=>Ipul::summary(),
            //the number of follower
            'followerkhof'=>GroupInfo::followersKhof(),
            'followeripul'=>GroupInfo::followersIpul()
        ]);
    }

}
