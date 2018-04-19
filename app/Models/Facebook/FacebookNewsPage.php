<?php

namespace App\Models\Facebook;

use Illuminate\Support\Facades\DB;

/**
 * A helper class to represent the aggregate of posts from News Portal's FB Pages
 */
class FacebookNewsPage {

    protected $newspage;

    public function getNewsPage() {
        return $this->newspage;
    }

    public static function getFollower() {
        try {
            $page = config("facebook.newspages." . (new static)->getNewsPage());
        } catch (\Illuminate\Container\EntryNotFoundException $e) {
            return 0;
        }
        $fol = GroupInfo::getInfo($page)->fan_count;
        return $fol;
    }

    /**
     * Return the number of all feeds that contains specific keyword
     * @param type $keyword one of [Ipul, Puti, Khofifah, Emil Dardak]
     */
    public static function getTotalPostNum($keyword) {
        
    }

    /**
     * Return page post containing specific keyword that gathers the most interaction.
     * Interaction is measured as the sum of like, comments and share of that post.
     * Hot Thread is updated daily.
     * @param type $keyword
     */
    public static function getHotThread($keyword = null) {
        $now = strtotime('now');
        $day_end = $now;
        $day_start = $now - 24 * 3600;
        $hot = DB::collection(GroupInfo::getInfo((new static)->getNewsPage())->collection)
                ->whereBetween('created_time', [date_create("@$day_start"), date_create("@$day_end")])
                ->when($keyword, function($query) use ($keyword) {
                    return $query->where('keyword', $keyword);
                })
                ->orderBy('interaction', 'DESC')
                ->limit(1)
                ->first();
        return $hot;
    }

    public static function getToday($keyword) {
        
    }

}
