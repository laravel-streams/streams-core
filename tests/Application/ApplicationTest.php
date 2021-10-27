<?php

namespace Streams\Core\Tests\Appilcation;

use Tests\TestCase;
use Streams\Core\Support\Facades\Applications;

class ApplicationTest extends TestCase
{

    public function testArrayable()
    {
        $this->assertEquals([
            'id',
            'match',
        ], array_keys(Applications::make('default')->toArray()));
    }

    public function testJsonable()
    {
        $this->assertEquals([
            'id',
            'match',
        ], array_keys(json_decode(Applications::make('default')->toJson(), true)));
    }
}
