<?php

namespace Streams\Core\Tests\Asset;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Asset\AssetRegistry;

class AssetRegistryTest extends CoreTestCase
{

    public function test_it_registers_named_assets()
    {
        $registry = new AssetRegistry;

        $registry->register('testing.js', $registered = 'public::vendor/core/tests/testing.js');

        $this->assertEquals($registered, $registry->resolve('testing.js'));
    }
}
