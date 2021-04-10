<?php

namespace Streams\Core\Tests\Addon;

use Tests\TestCase;
use Streams\Core\Addon\Addon;
use Streams\Core\Addon\AddonCollection;
use Streams\Core\Support\Facades\Addons;

class AddonManagerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));
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
    }
}
