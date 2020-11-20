<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Source Configuration
    |--------------------------------------------------------------------------
    |
    | Configure Stream sources.
    |
    */
    
    'default' => env('STREAMS_SOURCE', 'filebase'),

    'types' => [

        'filebase' => [

            'format' => env('STREAMS_SOURCE_FORMAT', 'md'),
            //'path' => env('STREAMS_SOURCE_PATH', 'streams/data'),
            
            'formats' => [
                'json' => \Streams\Core\Criteria\Format\Json::class,
                'yaml' => \Streams\Core\Criteria\Format\Yaml::class,
                'md' => \Streams\Core\Criteria\Format\Markdown::class,
                'template' => \Streams\Core\Criteria\Format\Template::class,
            ],
        ],
    ],
];
