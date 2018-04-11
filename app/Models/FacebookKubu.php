<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

/**
 * A helper class to represent the aggregate of posts from pages of each party
 */
class FacebookKubu {

    protected $party;

    public function getParty() {
        return $this->party;
    }

    /**
     * The number of total post from each party
     * @return int the sum of total post from each party's pages
     */
    public static function totalPostNum() {
        $sumToday = 0;
        try {
            $kubu = config("facebook.parties." . (new static)->getParty());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return 0;
        }
        foreach ($kubu['pages'] as $page) {
            // count each page's total post
            $sumToday += DB::collection(config('facebook.page_collection_prefix').'.'.$page)->count();
        }
        return $sumToday;
    }

    /**
     * The number of post in the last 7 days
     * @return array
     */
    public static function weeklyPostNum() {
        $ret = [];
        $today = strtotime('today');
        try {
            $kubu = config("facebook.parties." . (new static)->getParty());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return [0, 0, 0, 0, 0, 0, 0];
        }

        for ($i = 6; $i >= 0; $i--) {
            $day_start = $today - $i * 24 * 3600;
            $day_end = $today - ($i - 1) * 24 * 3600;
            $postNum = 0;
            foreach ($kubu['pages'] as $page) {
                $postNum = DB::collection(config('facebook.page_collection_prefix').'.'.$page)
                        ->whereBetween('created_time', [date_create("@$day_start"), date_create("@$day_end")])
                        ->count();
            }
            $ret[] = $postNum;
        }
        return $ret;
    }

    public static function getPastDay($i) {
        $today = strtotime('today');
        $ret = 0;
        try {
            $kubu = config("facebook.parties." . (new static)->getParty());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return $ret;
        }

        $day_start = $today - $i * 24 * 3600;
        $day_end = $today - ($i - 1) * 24 * 3600;
        $postNum = 0;
        foreach ($kubu['pages'] as $page) {
            $postNum = DB::collection(config('facebook.page_collection_prefix').'.'.$page)
                    ->whereBetween('created_time', [date_create("@$day_start"), date_create("@$day_end")])
                    ->count();
        }
        $ret = $postNum;
        return $ret;
    }

    public static function getToday() {
        return (new static)->getPastDay(0);
    }

    public static function getYesterday() {
        return (new static)->getPastDay(1);
    }

    /**
     * Total likes, comments and shares, in that particular order
     * @return array
     */
    public static function summary() {
        try {
            $kubu = config("facebook.parties." . (new static)->getParty());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return [0, 0, 0, 0];
        }
        $l = 0;
        $c = 0;
        $s = 0;
        foreach ($kubu['pages'] as $page) {
            $f = DB::collection(config('facebook.page_collection_prefix').'.'.$page);
            $l += $f->sum('likes.summary.total_count');
            $c += $f->sum('comments.summary.total_count');
            $s += $f->sum('shares.count');
        }
        return [$l, $c, $s, $l + $c + $s];
    }

    public static function getFollower() {
        try {
            $kubu = config("facebook.parties." . (new static)->getParty());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return 0;
        }
        $fol = 0;
        foreach ($kubu['pages'] as $page) {
            $fol += GroupInfo::getInfo($page)->fan_count;
        }
        return $fol;
    }

}
