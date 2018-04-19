<?php

namespace App\Models\Facebook;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Represents a collection of all fb post from khofifah-based fanpages
 */
class GroupInfo extends Eloquent {

    protected $guarded = [];
    protected $collection = 'fbinfo';

    /**
     * The number of new post today
     * @return int
     */
    public static function followersKhof() {
        return (new static)->raw()->findOne(['page_name' => 'khofifahemiljatim'])->fan_count;
    }

    /**
     * The number of post in the last 7 days
     * @return array 
     */
    public static function followersIpul() {
        return (new static)->raw()->findOne(['page_name' => 'jatimsedulur'])->fan_count;
    }

    public static function getInfo($page_name) {
        return GroupInfo::where('page_name', $page_name)->first();
    }
    
    public static function lastUpdate(){
        return GroupInfo::min('last_fetch');
    }

}
