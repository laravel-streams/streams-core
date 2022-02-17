<?php

namespace Streams\Core\Tests\Image;

use Streams\Core\Image\ImagePaths;
use Streams\Core\Tests\CoreTestCase;

class ImagePathsTest extends CoreTestCase
{

    public function test_it_sets_and_gets_paths()
    {
        $paths = new ImagePaths;

        $paths->setPaths([
            'foo' => 'bar',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
        ], $paths->getPaths());
    }

    public function test_it_resolves_hinted_paths()
    {
        $paths = new ImagePaths;

        $paths->addPath('core-tests', 'vendor/core/tests/');

        $this->assertEquals('vendor/core/tests', $paths->getPath('core-tests'));
        $this->assertEquals('/vendor/core/tests/example.jpg', $paths->real('core-tests::example.jpg'));
        $this->assertEquals('/vendor/core/tests/example.jpg', $paths->real('core-tests::example.jpg?v=12345'));
    }

    public function test_it_throws_exception_when_hint_does_not_exist()
    {
        $paths = new ImagePaths;

        $this->expectException(\Exception::class);
        
        $this->assertEquals('/vendor/core/tests/example.jpg', $paths->real('core-tests::example.jpg'));
    }
}
