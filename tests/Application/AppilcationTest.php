<?php

namespace Streams\Core\Tests\Appilcation;

use Tests\TestCase;
use Streams\Core\Support\Facades\Applications;

class AppilcationTest extends TestCase
{

    public function testArrayable()
    {
        $this->assertEquals([
            'id',
            'handle',
            'match',
            'stream',
            'listeners',
            'observers',
        ], array_keys(Applications::make('default')->toArray()));
    }

    public function testJsonable()
    {
        $this->assertEquals([
            'id',
            'handle',
            'match',
            'stream',
            'listeners',
            'observers',
        ], array_keys(json_decode(Applications::make('default')->toJson(), true)));
    }
}
