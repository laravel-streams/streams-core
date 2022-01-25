<?php

namespace Streams\Core\Tests\Addon;

use Tests\TestCase;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;
use Streams\Core\Support\Facades\Addons;

class AddonManagerTest extends TestCase
{

    public function testCanMakeRegisteredAddonInstance()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));

        $addon = Addons::make('streams/test-addon');

        $this->assertInstanceOf(Addon::class, $addon);
    }

    public function testCanReturnCollectionOfLoadedAddons()
    {
        Addons::load(base_path('vendor/streams/core/tests/addons/test-addon'));
        
        $addons = Addons::collection();

        $this->assertInstanceOf(Collection::class, $addons);
    }
}
