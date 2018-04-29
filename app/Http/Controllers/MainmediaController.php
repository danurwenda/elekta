<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mainmedia\Emil;
use App\Models\Mainmedia\Ipul;
use App\Models\Mainmedia\Khofifah;
use App\Models\Mainmedia\Puti;
use Carbon\Carbon;


class MainmediaController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function getIndex() {
        return view('pages.mainmedia');
    }

    public function getMediaKhofifah() {
        $khof = MainmediaController::getJSON('https://www.google.com/alerts/feeds/17433293890439964009/8778119014002706904');

        return view('pages.mainmedia.feedkhofifah', ['khof' => $khof]);
    }

    public function getMediaIpul() {
        $ipul = MainmediaController::getJSON('https://www.google.com/alerts/feeds/17433293890439964009/14634290886364729844');
        return view('pages.mainmedia.feedipul', ['ipul' => $ipul]);
    }

    public function getMediaEmil() {
        $emil = MainmediaController::getJSON('https://www.google.com/alerts/feeds/00126744657586499831/9896309034371372850');
        return view('pages.mainmedia.feedemil', ['emil' => $emil]);
    }

    public function getMediaPuti() {
        $puti = MainmediaController::getJSON('https://www.google.com/alerts/feeds/00126744657586499831/16017706715267162769');
        return view('pages.mainmedia.feedputi', ['puti' => $puti]);
    }

    public function show() {
        $khof = $this->getJSON('https://www.google.com/alerts/feeds/17433293890439964009/8778119014002706904');
        $ipul = $this->getJSON('https://www.google.com/alerts/feeds/17433293890439964009/14634290886364729844');
        //$khofemil = $this->getJSON('https://www.google.com/alerts/feeds/17433293890439964009/5985084613932103640');
        //$ipulputi = $this->getJSON('https://www.google.com/alerts/feeds/17433293890439964009/17941242850285220973');
        return view('mainstream', ['khof' => $khof, 'ipul' => $ipul]);
    }

    public static function countAll($id) {
        switch ($id) {
            case 1:
                $news = Khofifah::count();
                break;
            case 2:
                $news = Ipul::count();
                break;
            case 3:
                $news = Emil::count();
                break;
            case 4:
                $news = Puti::count();
                break;
        }


        return $news;
    }

    public static function getJSON($url) {

        $xml_string = file_get_contents($url);
        $xml = simplexml_load_string($xml_string);
        $json = json_encode($xml);
        $json = json_decode($json, TRUE);
        return $json['entry'];
    }

    public static function getMedia($url) {
        $media = str_after($url, 'https://www.google.com/url?rct=j&sa=t&url=');
        $media = str_after($media, '://');
        $media = str_before($media, '/');
        return $media;
    }

    public static function getToday($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $todaySum = Khofifah::whereBetween('published', [$today, $tomorrow])->get()->count();
                break;
            case 2:
                $todaySum = Emil::whereBetween('published', [$today, $tomorrow])->get()->count();
                break;
            case 3:
                $todaySum = Ipul::whereBetween('published', [$today, $tomorrow])->get()->count();
                break;
            case 4:
                $todaySum = Puti::whereBetween('published', [$today, $tomorrow])->get()->count();
                break;
        }


        return $todaySum;
    }
    
    public static function getPastDay($id,$i){
        $start = Carbon::today(config('app.timezone'))->subDays($i);
        $end = Carbon::today(config('app.timezone'))->subDays($i-1);
        switch ($id) {
            case 1:
                $todaySum = Khofifah::whereBetween('published', [$start, $end])->get()->count();
                break;
            case 2:
                $todaySum = Emil::whereBetween('published', [$start, $end])->get()->count();
                break;
            case 3:
                $todaySum = Ipul::whereBetween('published', [$start, $end])->get()->count();
                break;
            case 4:
                $todaySum = Puti::whereBetween('published', [$start, $end])->get()->count();
                break;
        }


        return $todaySum;
    }

    public static function getYesterday($id) {
        return MainmediaController::getPastDay($id,1);
    }

    private static function mediaCountAggregate($col, $start, $end) {
        return $col->aggregate([
                    [
                        '$match' => [
                            'published' => [
                                '$gte' => new \MongoDB\BSON\UTCDateTime(1000 * $start->getTimestamp())
                                , '$lt' => new \MongoDB\BSON\UTCDateTime(1000 * $end->getTimestamp())
                            ]
                        ]
                    ],
                    [
                        '$group' => [
                            '_id' => [
                                'media' => '$media'
                            ],
                            'count' => ['$sum' => 1]
                        ]
                    ],
                    [
                        '$sort' => ['count' => -1]
                    ]
        ]);
    }

    public static function getMediaCount($id) {
        $today = Carbon::today(config('app.timezone'));
        $tomorrow = Carbon::tomorrow(config('app.timezone'));
        switch ($id) {
            case 1:
                $json = Khofifah::raw(function($collection) use ($today, $tomorrow) {
                            return MainmediaController::mediaCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 2:
                $json = Emil::raw(function($collection) use ($today, $tomorrow) {
                            return MainmediaController::mediaCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 3:
                $json = Ipul::raw(function($collection) use ($today, $tomorrow) {
                            return MainmediaController::mediaCountAggregate($collection, $today, $tomorrow);
                        });
                break;
            case 4:
                $json = Puti::raw(function($collection) use ($today, $tomorrow) {
                            return MainmediaController::mediaCountAggregate($collection, $today, $tomorrow);
                        });
                break;
        }
        $data2 = [];
        foreach ($json as $data) {
            $new = [];
            $new['media'] = $data['_id']['media'];
            $new['count'] = $data['count'];
            array_push($data2, $new);
        }
        return json_encode($data2);
    }

    public static function getWeeks() {
        $datakhof = Khofifah::raw(function($collection) {
                    return $collection->aggregate([
                                [
                                    '$group' => [
                                        '_id' => [
                                            'date' => ['$substr' => ['$published', 0, 10]]
                                        ],
                                        'khofifah' => ['$sum' => 1]
                                    ]
                                ],
                                [
                                    '$sort' => ['_id.published' => 1]
                                ]
                    ]);
                });
        $dataipul = Ipul::raw(function($collection) {
                    return $collection->aggregate([
                                [
                                    '$group' => [
                                        '_id' => [
                                            'date' => ['$substr' => ['$published', 0, 10]]
                                        ],
                                        'ipul' => ['$sum' => 1]
                                    ]
                                ],
                                [
                                    '$sort' => ['_id.published' => 1]
                                ]
                    ]);
                });

        $dataemil = Emil::raw(function($collection) {
                    return $collection->aggregate([
                                [
                                    '$group' => [
                                        '_id' => [
                                            'date' => ['$substr' => ['$published', 0, 10]]
                                        ],
                                        'emil' => ['$sum' => 1]
                                    ]
                                ],
                                [
                                    '$sort' => ['_id.published' => 1]
                                ]
                    ]);
                });
        $dataputi = Puti::raw(function($collection) {
                    return $collection->aggregate([
                                [
                                    '$group' => [
                                        '_id' => [
                                            'date' => ['$substr' => ['$published', 0, 10]]
                                        ],
                                        'puti' => ['$sum' => 1]
                                    ]
                                ],
                                [
                                    '$sort' => ['_id.published' => 1]
                                ]
                    ]);
                });

        $array = [];
        for ($i = 6; $i >= 0; $i--) {
            $new = [];
            $new['date'] = Carbon::now()->subDays($i)->toDateString();
            $new['khofifah'] = 0;
            $new['ipul'] = 0;
            $new['emil'] = 0;
            $new['puti'] = 0;

            foreach ($datakhof as $data) {

                if ($data['_id.date'] == Carbon::now()->subDays($i)->toDateString()) {
                    $new['khofifah'] += $data['khofifah'];
                    break;
                }
            }

            foreach ($dataipul as $data) {

                if ($data['_id.date'] == Carbon::now()->subDays($i)->toDateString()) {
                    $new['ipul'] += $data['ipul'];
                    break;
                }
            }

            foreach ($dataemil as $data) {

                if ($data['_id.date'] == Carbon::now()->subDays($i)->toDateString()) {
                    $new['emil'] += $data['emil'];
                    break;
                }
            }

            foreach ($dataputi as $data) {

                if ($data['_id.date'] == Carbon::now()->subDays($i)->toDateString()) {
                    $new['puti'] += $data['puti'];
                    break;
                }
            }

            array_push($array, $new);
        }


        return json_encode($array);
    }

    public static function getData($id) {
        switch ($id) {
            case 1:
                $data = Khofifah::raw(function($collection) {
                            return $collection->aggregate([
                                        [
                                            '$group' => [
                                                '_id' => [
                                                    'published' => ['$substr' => ['$published', 0, 10]]
                                                ],
                                                'count' => ['$sum' => 1]
                                            ]
                                        ]
                            ]);
                        });
                break;
            case 2:
                $data = Ipul::raw(function($collection) {
                            return $collection->aggregate([
                                        [
                                            '$group' => [
                                                '_id' => [
                                                    'published' => ['$substr' => ['$published', 0, 10]]
                                                ],
                                                'count' => ['$sum' => 1]
                                            ]
                                        ]
                            ]);
                        });
                break;
        }


        $count = array();
        foreach ($data as $data) {
            array_push($count, $data['count']);
        }
        return json_encode($count);
    }

}
