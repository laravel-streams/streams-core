<?php

namespace Streams\Core\Tests\Asset;

use Tests\TestCase;
use Streams\Core\Asset\AssetCollection;
use Streams\Core\Support\Facades\Assets;

class AssetCollectionTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/testing.js'),
            public_path('vendor/streams/core/tests/testing.css'),
        ];

        if (!is_dir(dirname($filenames[0]))) {
            mkdir(dirname($filenames[0]), 0777, true);
        }

        foreach ($filenames as $filename) {
            if (!file_exists($filename)) {
                file_put_contents($filename, 'Test ' . basename($filename),);
            }
        }
    }

    public function tearDown(): void
    {
        $this->createApplication();

        $filenames = [
            public_path('vendor/streams/core/tests/testing.js'),
            public_path('vendor/streams/core/tests/testing.css'),
        ];

        foreach ($filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    public function testCanAddAsset()
    {
        $assets = new AssetCollection();

        $assets->add('theme.js');

        $this->assertEquals(['theme.js'], $assets->values()->all());
    }

    public function testCanLoadUnregisteredAsset()
    {
        $assets = new AssetCollection();

        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function testCanLoadRegisteredAsset()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function testOnlyLoadsAssetOnce()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('load.js');
        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function testCanResolveAssets()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            'resolved.js'
        ], $assets->resolved()->values()->all());
    }

    public function testCanReturnAssetUrls()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            url('resolved.js'),
        ], $assets->urls()->values()->all());
    }

    public function testCanReturnTagsAsset()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');
        $assets->add('testing.css');

        $this->assertEquals([
            '<script src="/resolved.js"></script>',
            '<link media="all" type="text/css" rel="stylesheet" href="/testing.css"/>',
        ], $assets->tags()->values()->all());
    }

    public function testCanReturnScriptTagsForAssets()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            '<script src="/resolved.js"></script>',
        ], $assets->scripts()->values()->all());
    }

    public function testCanReturnStyleTagsForAssets()
    {
        $assets = new AssetCollection();

        Assets::register('testing.css', 'resolved.css');

        $assets->load('testing.css');

        $this->assertEquals([
            '<link media="all" type="text/css" rel="stylesheet" href="/resolved.css"/>',
        ], $assets->styles()->values()->all());
    }

    public function testCanReturnInlineTags()
    {
        $assets = new AssetCollection();

        $assets->add('vendor/streams/core/tests/testing.css');

        $this->assertEquals([
            '<style media="all" type="text/css" rel="stylesheet">Test testing.css</style>',
        ], $assets->inlines()->values()->all());
    }

    public function testCanReturnContentForAssets()
    {
        $assets = new AssetCollection();

        $assets->add('vendor/streams/core/tests/testing.css');

        $this->assertEquals([
            'Test testing.css',
        ], $assets->content()->values()->all());
    }

    public function testCollectionToString()
    {
        $assets = new AssetCollection();

        $assets->add('testing.js');
        $assets->add('testing2.js');

        $this->assertEquals(
            url('testing.js') . "\n" . url('testing2.js'),
            (string) $assets->urls()
        );
    }
}
