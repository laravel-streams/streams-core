<?php

class AssetTest extends TestCase
{

    public function testCanDownload()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $target = 'https://gist.githubusercontent.com/RyanThompson/f75b540ecbd3bc9b5ee8614ccd4dc080/raw/89d093c39194a5875b39da930f97f5b18cf07efd/test.css';

        $path = $asset->download($target);

        $this->assertEquals(
            file_get_contents($target),
            file_get_contents($asset->realPath($path))
        );

        $content = $asset->inline($path);

        $this->assertEquals($content, file_get_contents($target));
    }

    public function testInline()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.js')),
            $asset->inline('streams::testing/example.js')
        );

        $this->assertEquals(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
            $asset->inline('streams::testing/example.css')
        );
    }

    public function testUrl()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            url('app/default/assets/anomaly/streams-platform/resources/testing/example.js'),
            $asset->url('streams::testing/example.js', ['noversion'])
        );
    }

    public function testPath()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            '/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            $asset->path('streams::testing/example.js', ['noversion'])
        );
    }

    public function testAsset()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            '/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            $asset->asset('streams::testing/example.js', ['noversion'])
        );
    }

    public function testScript()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example.js"></script>',
            $asset->script('streams::testing/example.js', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testStyle()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $this->assertEquals(
            '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css">',
            $asset->style('streams::testing/example.css', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testScripts()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->add('test.js', 'streams::testing/example.js');
        $asset->add('test.js', 'streams::testing/example2.js');

        $this->assertEquals(
            [
                '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example.js"></script>',
                '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example2.js"></script>',
            ],
            $asset->scripts('test.js', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testStyles()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->add('test.css', 'streams::testing/example.css');
        $asset->add('test.css', 'streams::testing/example2.css');

        $this->assertEquals(
            [
                '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css">',
                '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example2.css">',
            ],
            $asset->styles('test.css', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testPaths()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->add('test.css', 'streams::testing/example.css');
        $asset->add('test.css', 'streams::testing/example2.css');

        $this->assertEquals(
            [
                '/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
                '/app/default/assets/anomaly/streams-platform/resources/testing/example2.css',
            ],
            $asset->paths('test.css', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testUrls()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->add('test.css', 'streams::testing/example.css');
        $asset->add('test.css', 'streams::testing/example2.css');

        $this->assertEquals(
            [
                url(
                    'app/default/assets/anomaly/streams-platform/resources/testing/example.css'
                ),
                url(
                    'app/default/assets/anomaly/streams-platform/resources/testing/example2.css'
                ),
            ],
            $asset->urls('test.css', ['noversion'])
        );
    }

    public function testInlines()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->add('test.css', 'streams::testing/example.css');
        $asset->add('test.css', 'streams::testing/example2.css');

        $this->assertEquals(
            [
                file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
                file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example2.css')),
            ],
            $asset->inlines('test.css', ['noversion'], ['foo' => 'bar'])
        );
    }

    public function testLastModifiedAt()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $time = time();

        touch($asset->realPath('streams::testing/example.css'), $time);

        $this->assertEquals(
            $time,
            $asset->lastModifiedAt('streams::testing/')
        );
    }

    public function testAddPath()
    {
        /* @var \Anomaly\Streams\Platform\Asset\Asset $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\Asset::class);

        $asset->addPath(
            'testing',
            base_path('vendor/anomaly/streams-platform/resources/testing')
        );

        $this->assertEquals(
            base_path('vendor/anomaly/streams-platform/resources/testing/example.css'),
            $asset->realPath('testing::example.css')
        );
    }
}
