<?php

namespace Streams\Core\Tests\Asset;

use Streams\Core\Asset\AssetCollection;
use Streams\Core\Support\Facades\Assets;
use Tests\TestCase;

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
                file_put_contents($filename, 'Test ' . basename($filename), );
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

    public function testAdd()
    {
        $assets = new AssetCollection();

        $assets->add('theme.js');

        $this->assertEquals(['theme.js' => 'theme.js'], $assets->all());
    }

    public function testLoad()
    {
        $assets = new AssetCollection();

        $assets->load('load.js');

        $this->assertEquals(['load.js' => 'load.js'], $assets->all());

        $assets->load('load.js');

        $this->assertEquals(['load.js' => 'load.js'], $assets->all());
    }

    public function testResolved()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals(['resolved.js' => 'resolved.js'], $assets->resolved()->all());
    }

    public function testUrls()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            'resolved.js' => 'http://streams.local::8888/resolved.js',
        ], $assets->urls()->all());
    }

    public function testTags()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            'resolved.js' => '<script src="/resolved.js"></script>',
        ], $assets->tags()->all());
    }

    public function testScripts()
    {
        $assets = new AssetCollection();

        Assets::register('testing.js', 'resolved.js');

        $assets->load('testing.js');

        $this->assertEquals([
            'resolved.js' => '<script src="/resolved.js"></script>',
        ], $assets->scripts()->all());
    }

    public function testStyles()
    {
        $assets = new AssetCollection();

        Assets::register('testing.css', 'resolved.css');

        $assets->load('testing.css');

        $this->assertEquals([
            'resolved.css' => '<link media="all" type="text/css" rel="stylesheet" href="/resolved.css"/>',
        ], $assets->styles()->all());
    }

    public function testInlines()
    {
        $assets = new AssetCollection();

        $assets->add('vendor/streams/core/tests/testing.css');

        $this->assertEquals([
            'vendor/streams/core/tests/testing.css' => '<style media="all" type="text/css" rel="stylesheet">Test testing.css</style>',
        ], $assets->inlines()->all());
    }

    public function testContent()
    {
        $assets = new AssetCollection();

        $assets->add('vendor/streams/core/tests/testing.css');

        $this->assertEquals([
            'vendor/streams/core/tests/testing.css' => 'Test testing.css',
        ], $assets->content()->all());
    }

    public function testToString()
    {
        $assets = new AssetCollection();

        $assets->add('testing.js');
        $assets->add('testing2.js');

        $this->assertEquals("http://streams.local::8888/testing.js\nhttp://streams.local::8888/testing2.js", (string) $assets->urls());
    }
}
