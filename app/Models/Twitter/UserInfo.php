<?php

namespace App\Models\Twitter;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Represents a collection of all fb post from khofifah-based fanpages
 */
class UserInfo extends Eloquent {

    protected $guarded = [];
    protected $collection = 'tweetinfo';

    public static function getInfo($screen_name) {
        return UserInfo::where('screen_name', $screen_name)->first();
    }

    public static function lastUpdate() {
        return UserInfo::min('last_fetch');
    }

}
