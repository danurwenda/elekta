<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Represents a collection of all fb post from khofifah-based fanpages
 */
class GroupInfo extends Eloquent {

    protected $collection = 'groupinfo';

    /**
     * The number of new post today
     * @return int
     */
    public static function followersKhof() {
        return 7108;
    }

    /**
     * The number of post in the last 7 days
     * @return array 
     */
    public static function followersIpul() {
        return 332757;
    }

}
