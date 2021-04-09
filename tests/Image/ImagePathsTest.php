<?php

namespace Streams\Core\Tests\Image;

use Tests\TestCase;
use Streams\Core\Image\ImagePaths;

class ImagePathsTest extends TestCase
{

    public function testAccessors()
    {
        $paths = new ImagePaths;

        $paths->setPaths([
            'foo' => 'bar',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
        ], $paths->getPaths());
    }

    public function testRegister()
    {
        $paths = new ImagePaths;

        $paths->addPath('core-tests', 'vendor/core/tests/');

        $this->assertEquals('vendor/core/tests', $paths->getPath('core-tests'));
        $this->assertEquals('/vendor/core/tests/example.jpg', $paths->real('core-tests::example.jpg'));
        $this->assertEquals('/vendor/core/tests/example.jpg', $paths->real('core-tests::example.jpg?v=12345'));
    }
}
