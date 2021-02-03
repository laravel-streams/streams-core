<?php

namespace Streams\Core\Tests\Addon;

use Streams\Core\Addon\Addon;
use Streams\Core\Addon\AddonCollection;
use Tests\TestCase;
use Streams\Core\Support\Facades\Addons;
use Streams\Core\Support\Facades\Streams;

class AddonManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $addon = Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));
    }

    public function testLoad()
    {
        $addon = Addons::make('streams/test-addon');

        $this->assertInstanceOf(Addon::class, $addon);
    }

    public function testCollection()
    {
        $addons = Addons::collection();

        $this->assertInstanceOf(AddonCollection::class, $addons);
        dd($addons->keys());
        $this->assertEquals(1, $addons->count());
    }
}
