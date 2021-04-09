<?php

namespace Streams\Core\Tests\Asset;

use Tests\TestCase;
use Streams\Core\Asset\AssetPaths;

class AssetPathsTest extends TestCase
{

    public function testAccessors()
    {
        $paths = new AssetPaths;

        $paths->setPaths([
            'foo' => 'bar',
        ]);

        $this->assertEquals([
            'foo' => 'bar',
        ], $paths->getPaths());
    }

    public function testRegister()
    {
        $paths = new AssetPaths;

        $paths->addPath('core-tests', 'vendor/core/tests/');

        $this->assertEquals('vendor/core/tests', $paths->getPath('core-tests'));
        $this->assertEquals('/vendor/core/tests/example.js', $paths->real('core-tests::example.js'));
        $this->assertEquals('/vendor/core/tests/example.js', $paths->real('core-tests::example.js?v=12345'));
    }
}
