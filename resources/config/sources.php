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
    
    'sources' => [

        'default' => env('STREAMS_SOURCE', 'filebase'),

        'types' => [

            'filebase' => [

                'format' => env('STREAMS_SOURCE_FORMAT', 'md'),
                //'path' => env('STREAMS_SOURCE_PATH', 'streams/data'),
                
                'formats' => [
                    'json' => \Filebase\Format\Json::class,
                    'yaml' => \Filebase\Format\Yaml::class,
                    'md' => \Anomaly\Streams\Platform\Criteria\Format\Markdown::class,
                ],
            ],
        ],
    ],
];
