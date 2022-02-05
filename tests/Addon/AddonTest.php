<?php

namespace Streams\Core\Tests\Addon;

use Streams\Core\Addon\Addon;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Addons;

class AddonTest extends CoreTestCase
{

    public function test_addons_are_arrayable()
    {
        Addons::load(base_path('addons/streams/test-addon'));

        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(Addons::make('streams/test-addon')->toArray()));
    }

    public function test_addons_are_jsonable()
    {
        Addons::load(base_path('addons/streams/test-addon'));
        
        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(json_decode(Addons::make('streams/test-addon')->toJson(), true)));
    }
}
