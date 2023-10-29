<?php

namespace Streams\Core\Tests\Addon;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Addons;

class AddonTest extends CoreTestCase
{
    public function test_it_returns_provisions()
    {
        $this->assertEquals(false, Addons::make('streams/testing')->provides('example.*'));
    }

    public function test_it_is_arrayable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(Addons::make('streams/testing')->toArray()));
    }

    public function test_it_is_jsonable()
    {
        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(json_decode(Addons::make('streams/testing')->toJson(), true)));
    }
}
