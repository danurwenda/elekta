<?php

return [
    'start_fetch' => 1518368400, // 12 feb 2018
    'app_id' => env('FACEBOOK_APP_ID', ''),
    'app_secret' => env('FACEBOOK_APP_SECRET', ''),
    'token' => env('FACEBOOK_APP_TOKEN', ''),
    'parties' => [
        //khofifah
        'khofifah' =>
        [
            'name' => 'Khofifah',
            'pages' => ['khofifahemiljatim', 'KhofifahdanEmil']
        ],
        //ipul
        'gusipul' =>
        [
            'name' => 'Gus Ipul',
            'pages' => ['jatimsedulur']
        ]
    ],
];
