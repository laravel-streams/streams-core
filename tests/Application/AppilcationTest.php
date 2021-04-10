<?php

namespace Streams\Core\Tests\Appilcation;

use Tests\TestCase;
use Streams\Core\Support\Facades\Appilcations;

class AppilcationTest extends TestCase
{

    public function testArrayable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
            'enabled',
            'listeners',
            'observers',
        ], array_keys(Appilcations::make('default')->toArray()));
    }

    public function testJsonable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
            'enabled',
            'listeners',
            'observers',
        ], array_keys(json_decode(Appilcations::make('default')->toJson(), true)));
    }
}
