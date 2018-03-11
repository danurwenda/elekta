<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

/**
 * Represents a collection of all fb post from khofifah-based fanpages
 */
class FacebookPage extends Eloquent {

    protected $dates = ['created_time'];

    /**
     * The number of new post today
     * @return int
     */
    public static function todayPostNum() {
        return (new static)->count();
    }

    /**
     * The number of post in the last 7 days
     * @return array 
     */
    public static function weeklyPostNum() {
        $ret = [];
        $today = strtotime('today');
        for ($i = 6; $i >= 0; $i--) {
            $day_start = $today - $i * 24 * 3600;
            $day_end = $today - ($i - 1) * 24 * 3600;
            $ret[] = (new static)
                    ->where('created_time', '>=', date_create("@$day_start"))
                    ->where('created_time', '<', date_create("@$day_end"))
                    ->count();
        }
//                ->where(['created_time' => array('$gt' => 30, '$lt' => 40)])->get();
        return $ret;
    }

    /**
     * Total likes, comments and shares, in that particular order
     * @return array
     */
    public static function summary() {
        $f = (new static);
        $l = $f->sum('likes.summary.total_count');
        $c = $f->sum('comments.summary.total_count');
        $s = $f->sum('shares.count');
        $t = $l + $c + $s;
        return [$l, $c, $s, $t];
    }

    /**
     * Total follower
     * @return int
     */
    public static function followers() {
        return 75000;
    }

}
