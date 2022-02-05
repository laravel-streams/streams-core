<?php

namespace Streams\Core\Tests\Addon;

use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Addons;

class AddonManagerTest extends CoreTestCase
{

    public function test_it_can_load_an_addon_by_path()
    {
        Addons::load(base_path('addons/streams/test-addon'));

        $addon = Addons::make('streams/test-addon');

        $this->assertInstanceOf(Addon::class, $addon);
    }

    public function test_it_can_return_a_collection_of_registered_addons()
    {
        Addons::load(base_path('addons/streams/test-addon'));
        
        $addons = Addons::collection();

        $this->assertInstanceOf(Collection::class, $addons);
    }
}
