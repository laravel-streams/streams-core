<?php

namespace Streams\Core\Tests\Asset;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Asset\AssetCollection;
use Streams\Core\Support\Facades\Assets;

class AssetCollectionTest extends CoreTestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // $filenames = [
        //     public_path('vendor/streams/test-addon/js/testing.js'),
        //     public_path('vendor/streams/test-addon/css/testing.css'),
        // ];

        // if (!is_dir(dirname($filenames[0]))) {
        //     mkdir(dirname($filenames[0]), 0777, true);
        // }

        // foreach ($filenames as $filename) {
        //     if (!file_exists($filename)) {
        //         file_put_contents($filename, 'Test ' . basename($filename),);
        //     }
        // }
    }

    // protected function tearDown(): void
    // {
    //     parent::tearDown();

    //     $filenames = [
    //         public_path('vendor/streams/test-addon/js/testing.js'),
    //         public_path('vendor/streams/test-addon/css/testing.css'),
    //     ];

    //     foreach ($filenames as $filename) {
    //         if (file_exists($filename)) {
    //             unlink($filename);
    //         }
    //     }
    // }

    public function test_it_adds_assets()
    {
        $assets = new AssetCollection();

        $assets->add('theme.js');

        $this->assertEquals(['theme.js'], $assets->values()->all());
    }

    public function test_it_loads_unregistered_assets()
    {
        $assets = new AssetCollection();

        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function test_it_loads_registered_assets()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function test_it_only_loads_assets_once()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('load.js');
        $assets->load('load.js');

        $this->assertEquals(['load.js'], $assets->values()->all());
    }

    public function test_it_returns_asset_urls()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            url('resolved.js'),
        ], $assets->urls()->values()->all());
    }

    public function test_it_returns_asset_tags()
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

    public function test_it_returns_script_tags()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            '<script src="/resolved.js"></script>',
        ], $assets->scripts()->values()->all());
    }

    public function test_it_returns_style_tags()
    {
        $assets = new AssetCollection();

        Assets::register('testing.css', 'resolved.css');

        $assets->load('testing.css');

        $this->assertEquals([
            '<link media="all" type="text/css" rel="stylesheet" href="/resolved.css"/>',
        ], $assets->styles()->values()->all());
    }

    public function test_it_returns_inline_asset_tags()
    {
        $assets = new AssetCollection();

        $assets->add('addons/streams/test-addon/css/testing.css');

        $this->assertEquals([
            '<style media="all" type="text/css" rel="stylesheet">Test testing.css</style>',
        ], $assets->inlines()->values()->all());
    }

    public function test_it_returns_asset_contents()
    {
        $assets = new AssetCollection();

        $assets->add('addons/streams/test-addon/css/testing.css');

        $this->assertEquals([
            'Test testing.css',
        ], $assets->content()->values()->all());
    }

    public function test_to_string_returns_empty_string()
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
