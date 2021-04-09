<?php

namespace Streams\Core\Tests\Asset;

use Tests\TestCase;
use Streams\Core\Asset\AssetRegistry;

class AssetRegistryTest extends TestCase
{

    public function testRegister()
    {
        $registry = new AssetRegistry;

        $registry->register('testing.js', $registered = 'public::vendor/core/tests/testing.js');

        $this->assertEquals($registered, $registry->resolve('testing.js'));
    }
}
