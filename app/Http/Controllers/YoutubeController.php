<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Youtube\Emil;
use App\Models\Youtube\Khofifah;
use App\Models\Youtube\Puti;
use App\Models\Youtube\Ipul;
use Carbon\Carbon;

class YoutubeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.sosmed.youtube');
    }

    public static function countAll($id) {
        switch ($id) {
            case 1:
                $youtube = Khofifah::count();
                break;
            case 2:
                $youtube = Ipul::count();
                break;
            case 3:
                $youtube = Emil::count();
                break;
            case 4:
                $youtube = Puti::count();
                break;
        }

        return $youtube;
    }

    public static function getToday($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $today = Khofifah::whereBetween('snippet.publishedAt', [$today, $tomorrow])->get()->count();
                break;
            case 2:
                $today = Emil::whereBetween('snippet.publishedAt', [$today, $tomorrow])->get()->count();
                break;
            case 3:
                $today = Ipul::whereBetween('snippet.publishedAt', [$today, $tomorrow])->get()->count();
                break;
            case 4:
                $today = Puti::whereBetween('snippet.publishedAt', [$today, $tomorrow])->get()->count();
                break;
        }


        return $today;
    }

    public static function getPastDay($id, $i) {
        $start = Carbon::today(config('app.timezone'))->subDays($i);
        $end = Carbon::today(config('app.timezone'))->subDays($i - 1);
        switch ($id) {
            case 1:
                $todaySum = Khofifah::whereBetween('snippet.publishedAt', [$start, $end])->get()->count();
                break;
            case 2:
                $todaySum = Emil::whereBetween('snippet.publishedAt', [$start, $end])->get()->count();
                break;
            case 3:
                $todaySum = Ipul::whereBetween('snippet.publishedAt', [$start, $end])->get()->count();
                break;
            case 4:
                $todaySum = Puti::whereBetween('snippet.publishedAt', [$start, $end])->get()->count();
                break;
        }


        return $todaySum;
    }

    public static function getYesterday($id) {
        return YoutubeController::getPastDay($id, 1);
    }

    private static function getWeekAggregation($collection) {
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        $sixDaysAgo = Carbon::tomorrow(config('app.timezone'))->subWeek();
        return $collection->aggregate([
                    [
                        '$match' => [
                            'snippet.publishedAt' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $sixDaysAgo->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $tomorrow->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'date' => ['$dateToString' => ['timezone' => config('app.timezone'), 'format' => "%Y-%m-%d", 'date' => '$snippet.publishedAt']]
                            ],
                            'sum' => ['$sum' => 1]
                        ]
                    ]
        ]);
    }

    public static function getWeeks() {
        $datakhof = Khofifah::raw(function($collection) {
                    return YoutubeController::getWeekAggregation($collection);
                });
        $dataipul = Ipul::raw(function($collection) {
                    return YoutubeController::getWeekAggregation($collection);
                });
        $dataemil = Emil::raw(function($collection) {
                    return YoutubeController::getWeekAggregation($collection);
                });
        $dataputi = Puti::raw(function($collection) {
                    return YoutubeController::getWeekAggregation($collection);
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

    private static function userCountAggregate($col, $start, $end) {
        return $col->aggregate([
                    [
                        '$match' => [
                            'snippet.publishedAt' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $start->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $end->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'user' => '$snippet.channelId',
                                'name' => '$snippet.channelTitle'
                            ],
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => ['count' => -1]
                    ]
        ]);
    }

    public static function getUserCount($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $json = Khofifah::raw(function($collection) use ($today, $tomorrow) {
                            return YoutubeController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 2:
                $json = Emil::raw(function($collection) use ($today, $tomorrow) {
                            return YoutubeController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 3:
                $json = Ipul::raw(function($collection) use ($today, $tomorrow) {
                            return YoutubeController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 4:
                $json = Puti::raw(function($collection) use ($today, $tomorrow) {
                            return YoutubeController::userCountAggregate($collection, $today, $tomorrow);
                        });
                break;
        }

        $data2 = [];
        foreach ($json as $data) {
            $new = [];
            $new['user'] = $data['_id']['user'];
            $new['username'] = $data['_id']['name'];
            $new['count'] = $data['count'];
            array_push($data2, $new);
        }
        return json_encode($data2);
    }

}
