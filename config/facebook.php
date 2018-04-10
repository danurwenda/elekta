<?php

return [
    'start_fetch' => 1518368400, // 12 feb 2018
    'app_id' => env('FACEBOOK_APP_ID', ''),
    'app_secret' => env('FACEBOOK_APP_SECRET', ''),
    'token' => env('FACEBOOK_APP_TOKEN', ''),
    'page_collection_prefix'=>'FBPage',
    'news_collection_prefix'=>'FBNews',
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
    'keywords'=>['Emil Dardak','Puti ','Khofifah ','Gus Ipul'],
    'newspages'=>[
        'detikcom',
        'KompasTV',
        'KOMPAScom'
    ]
];
