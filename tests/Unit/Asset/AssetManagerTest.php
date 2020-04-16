<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Asset\AssetCollection;
use Anomaly\Streams\Platform\Asset\Facades\Assets;

/**
 * Class AssetManagerTest
 */
class AssetManagerTest extends TestCase
{

    public function testCollection()
    {
        $this->assertInstanceOf(AssetCollection::class, Assets::collection('test'));
    }

    public function testNamedAssets()
    {
        $this->assertEquals([
            'streams::testing/example.js' => 'streams::testing/example.js'
        ], Assets::register('example', 'streams::testing/example.js')->resolve('example'));

        $this->assertEquals([
            'example.js' => 'streams::testing/example.js'
        ], Assets::register('example', [
            'example.js' => 'streams::testing/example.js',
        ])->resolve('example'));
    }

    public function testInline()
    {
        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.js')),
            Assets::inline('streams::testing/example.js')
        );

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
            Assets::inline('streams::testing/example.css')
        );
    }

    public function testUrl()
    {
        $this->assertStringContainsString(
            url('app/default/assets/anomaly/streams-platform/resources/testing/example.js'),
            Assets::url('streams::testing/example.js')
        );
    }

    public function testPath()
    {
        $this->assertStringContainsString(
            '/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            Assets::path('streams::testing/example.js')
        );
    }

    public function testScript()
    {
        $this->assertStringContainsString(
            '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            Assets::script('streams::testing/example.js', ['foo' => 'bar'])
        );
    }

    public function testStyle()
    {
        $this->assertStringContainsString(
            '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
            Assets::style('streams::testing/example.css', ['foo' => 'bar'])
        );
    }

    public function testAddPath()
    {
        Assets::addPath(
            'testing',
            base_path('vendor/anomaly/streams-platform/resources/testing')
        );

        $this->assertSame(
            base_path('vendor/anomaly/streams-platform/resources/testing/example.css'),
            Assets::real('testing::example.css')
        );
    }
}
