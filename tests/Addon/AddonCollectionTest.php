<?php

namespace Streams\Core\Tests\Addon;

use Tests\TestCase;
use Streams\Core\Addon\Addon;
use Streams\Core\Addon\AddonCollection;
use Streams\Core\Support\Facades\Addons;

class AddonCollectionTest extends TestCase
{

    public function testCollectionContainsLoadedAddons()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));

        $addons = Addons::collection();

        $this->assertTrue($addons->count() >= 1);
    }

    // public function testCore()
    // {
    //     $addons = Addons::collection();

    //     $this->assertTrue($addons->core()->count() >= 1);
    // }

    // public function testNonCore()
    // {
    //     $addons = Addons::collection();

    //     $this->assertTrue($addons->nonCore()->count() == 0);
    // }

    // public function testEnabled()
    // {
    //     $addons = Addons::collection();

    //     $this->assertTrue($addons->enabled()->count() >= 1);
    // }

    // public function testDisabled()
    // {
    //     $addons = Addons::collection();

    //     $this->assertTrue($addons->disabled()->count() == 0);
    // }
}
