<?php

namespace Streams\Core\Tests\Asset;

use Streams\Core\Asset\AssetPaths;
use Streams\Core\Tests\CoreTestCase;

class AssetPathsTest extends CoreTestCase
{

    public function test_it_sets_and_gets_paths()
    {
        $paths = new AssetPaths;

        $paths->setPaths([
            'foo' => 'bar',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
        ], $paths->getPaths());
    }

    public function test_it_registers_paths()
    {
        $paths = new AssetPaths;

        $paths->addPath('core-tests', 'vendor/core/tests/');

        $this->assertEquals('vendor/core/tests', $paths->getPath('core-tests'));
        $this->assertEquals('/vendor/core/tests/example.js', $paths->real('core-tests::example.js'));
        $this->assertEquals('/vendor/core/tests/example.js', $paths->real('core-tests::example.js?v=12345'));
    }

    public function test_it_throws_exception_if_not_registered()
    {
        $paths = new AssetPaths;

        $this->expectException(\Exception::class);

        $paths->real('foo-bar::test.css');
    }
}
