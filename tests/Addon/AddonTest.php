<?php

namespace Streams\Core\Tests\Addon;

use Tests\TestCase;
use Streams\Core\Addon\Addon;
use Streams\Core\Support\Facades\Addons;

class AddonTest extends TestCase
{

    public function testCanLoadAddonByAbsolutePath()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));

        $this->assertInstanceOf(Addon::class, Addons::make('streams/test-addon'));
    }

    public function testAddonsAreArrayable()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));

        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(Addons::make('streams/test-addon')->toArray()));
    }

    public function testAddonsAreJsonable()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));
        
        $this->assertEquals([
            'name',
            'path',
            'composer',
        ], array_keys(json_decode(Addons::make('streams/test-addon')->toJson(), true)));
    }
}
