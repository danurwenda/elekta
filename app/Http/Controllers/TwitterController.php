<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TwitterController;
use App\Models\Twitter\Emil;
use App\Models\Twitter\Ipul;
use App\Models\Twitter\Khofifah;
use App\Models\Twitter\Puti;
use App\Models\Twitter\UserInfo;
use Carbon\Carbon;


class TwitterController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.sosmed.twitter', [
            'timestamp' => UserInfo::lastUpdate()]);
    }

    public static function countAll($id) {
        switch ($id) {
            case 1:
                $twitter = Khofifah::count();
                break;
            case 2:
                $twitter = Ipul::count();
                break;
            case 3:
                $twitter = Emil::count();
                break;
            case 4:
                $twitter = Puti::count();
                break;
        }

        return $twitter;
    }

    public static function getToday($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $todaySum = Khofifah::whereBetween('create_at', [$today, $tomorrow])->get()->count();
                break;
            case 2:
                $todaySum = Emil::whereBetween('create_at', [$today, $tomorrow])->get()->count();
                break;
            case 3:
                $todaySum = Ipul::whereBetween('create_at', [$today, $tomorrow])->get()->count();
                break;
            case 4:
                $todaySum = Puti::whereBetween('create_at', [$today, $tomorrow])->get()->count();
                break;
        }


        return $todaySum;
    }

    public static function getPastDay($id, $i) {
        $start = Carbon::today(config('app.timezone'))->subDays($i);
        $end = Carbon::today(config('app.timezone'))->subDays($i - 1);
        switch ($id) {
            case 1:
                $todaySum = Khofifah::whereBetween('create_at', [$start, $end])->get()->count();
                break;
            case 2:
                $todaySum = Emil::whereBetween('create_at', [$start, $end])->get()->count();
                break;
            case 3:
                $todaySum = Ipul::whereBetween('create_at', [$start, $end])->get()->count();
                break;
            case 4:
                $todaySum = Puti::whereBetween('create_at', [$start, $end])->get()->count();
                break;
        }


        return $todaySum;
    }

    public static function getYesterday($id) {
        return TwitterController::getPastDay($id, 1);
    }

    private static function hashCountAggregate($col, $start, $end) {
        return $col->aggregate([
                    [
                        '$match' => [
                            'create_at' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $start->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $end->getTimestamp())
                            ]
                        ]
                    ]
        ]);
    }

    private static function userCountAggregate($col, $start, $end) {
        return $col->aggregate([
                    [
                        '$match' => [
                            'create_at' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $start->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $end->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'user' => '$user.screen_name',
                                'followers' => '$user.followers_count',
                                'posts' => '$user.statuses_count'
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'user' => '$_id.user'
                            ],
                            'follower' => ['$first' => '$_id.followers'],
                            'post' => ['$first' => '$_id.posts']
                        ]
                    ],
                    [
                        '$sort' => ['follower' => -1]
                    ]
        ]);
    }

    public static function getUserCount($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $json = Khofifah::raw(function($collection) use ($today, $tomorrow) {
                            return TwitterController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 2:
                $json = Emil::raw(function($collection) use ($today, $tomorrow) {
                            return TwitterController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 3:
                $json = Ipul::raw(function($collection) use ($today, $tomorrow) {
                            return TwitterController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 4:
                $json = Puti::raw(function($collection) use ($today, $tomorrow) {
                            return TwitterController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
        }


        $json = $json->take(10);
        $data2 = [];
        foreach ($json as $data) {
            $new = [];
            $new['user'] = '@' . $data['_id']['user'];
            $new['follower'] = $data['follower'];
            $new['post'] = $data['post'];
            array_push($data2, $new);
        }
        return $data2;
    }

    public static function getHashtagCount($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $json = Khofifah::raw(function($collection) use($today, $tomorrow) {
                            return TwitterController::hashCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 2:
                $json = Emil::raw(function($collection) use($today, $tomorrow) {
                            return TwitterController::hashCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 3:
                $json = Ipul::raw(function($collection) use($today, $tomorrow) {
                            return TwitterController::hashCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 4:
                $json = Puti::raw(function($collection) use($today, $tomorrow) {
                            return TwitterController::hashCountAggregate($collection, $today, $tomorrow);
                        });
                break;
        }


        $data2 = [];
        foreach ($json as $data) {
            if ($data['entities']['hashtags']->count() > 0) {
                foreach ($data['entities']['hashtags'] as $datahashtag) {
                    array_push($data2, '#' . $datahashtag['text']);
                }
            }
        }

        $data2 = array_count_values($data2);
        arsort($data2);
        $data3 = [];
        foreach ($data2 as $key => $value) {
            $new = [];
            $new['hashtag'] = $key;
            $new['count'] = $value;
            array_push($data3, $new);
        }

        return json_encode($data3);
    }

    private static function getWeekAggregation($collection) {
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        $sixDaysAgo = Carbon::tomorrow(config('app.timezone'))->subWeek();
        return $collection->aggregate([
                    [
                        '$match' => [
                            'create_at' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $sixDaysAgo->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $tomorrow->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'date' => ['$dateToString' => ['timezone' => config('app.timezone'), 'format' => "%Y-%m-%d", 'date' => '$create_at']]
                            ],
                            'sum' => ['$sum' => 1]
                        ]
                    ]
        ]);
    }

    public static function getWeeks() {
        $datakhof = Khofifah::raw(function($collection) {
                    return TwitterController::getWeekAggregation($collection);
                });
        $dataipul = Ipul::raw(function($collection) {
                    return TwitterController::getWeekAggregation($collection);
                });
        $dataemil = Emil::raw(function($collection) {
                    return TwitterController::getWeekAggregation($collection);
                });
        $dataputi = Puti::raw(function($collection) {
                    return TwitterController::getWeekAggregation($collection);
                });

        $array = [];
        for ($i = 6; $i >= 0; $i--) {
            $new = [];
            $new['date'] = Carbon::now(config('app.timezone'))->subDays($i)->toDateString();
            $new['khofifah'] = 0;
            $new['ipul'] = 0;
            $new['emil'] = 0;
            $new['puti'] = 0;

            foreach ($datakhof as $data) {

                if ($data['_id.date'] == $new['date']) {
                    $new['khofifah'] += $data['sum'];
                    break;
                }
            }

            foreach ($dataipul as $data) {

                if ($data['_id.date'] == $new['date']) {
                    $new['ipul'] += $data['sum'];
                    break;
                }
            }

            foreach ($dataemil as $data) {

                if ($data['_id.date'] == $new['date']) {
                    $new['emil'] += $data['sum'];
                    break;
                }
            }

            foreach ($dataputi as $data) {

                if ($data['_id.date'] == $new['date']) {
                    $new['puti'] += $data['sum'];
                    break;
                }
            }

            array_push($array, $new);
        }


        return json_encode($array);
    }

}
