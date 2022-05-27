<?php

namespace Streams\Core\Tests\Criteria\Adapter;

use Streams\Core\Support\Facades\Streams;
use Streams\Core\Tests\Criteria\CriteriaTest;

class CsvFileAdapterTest extends CriteriaTest
{

    protected function setUp():void
    {
        parent::setUp();

        Streams::extend('films', [
            'config' => [
                'source' => [
                    'format' => 'csv',
                ],
            ],
        ]);
    }    
}
