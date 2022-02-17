<?php

namespace Streams\Core\Tests\Image;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Image\ImageRegistry;

class ImageRegistryTest extends CoreTestCase
{

    public function test_it_registers_images_by_name()
    {
        $registry = new ImageRegistry;

        $registered = 'public::vendor/core/tests/logo.png';
        
        $registry->register('logo.png', $registered);

        $this->assertEquals($registered, $registry->resolve('logo.png'));
    }
}
