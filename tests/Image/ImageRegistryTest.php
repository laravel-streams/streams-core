<?php

namespace Streams\Core\Tests\Image;

use Tests\TestCase;
use Streams\Core\Image\ImageRegistry;

class ImageRegistryTest extends TestCase
{

    public function testRegister()
    {
        $registry = new ImageRegistry;

        $registry->register('logo.png', $registered = 'public::vendor/core/tests/logo.png');

        $this->assertEquals($registered, $registry->resolve('logo.png'));
    }
}
