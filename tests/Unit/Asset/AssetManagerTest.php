<?php

use Tests\TestCase;

/**
 * @todo consider a more robust approach to testing assets rather than using empty static files
 *
 * Class AssetManagerTest
 */
class AssetManagerTest extends TestCase
{

    /**
     * @deprecated since 2.0 - download() covered under path()?
     * @todo confirm path() as replacement
     */
    public function testCanDownloadUsingPath()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $target = 'https://gist.githubusercontent.com/RyanThompson/f75b540ecbd3bc9b5ee8614ccd4dc080/raw/89d093c39194a5875b39da930f97f5b18cf07efd/test.css';

        $path = $asset->path($target);

        $this->assertStringContainsString(
            file_get_contents($target),
            file_get_contents($asset->real($path))
        );

        $content = $asset->inline($path);

        $this->assertStringContainsString($content, file_get_contents($target));
    }

    public function testInline()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.js')),
            $asset->inline('streams::testing/example.js')
        );

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
            $asset->inline('streams::testing/example.css')
        );
    }

    public function testUrl()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            url('app/default/assets/anomaly/streams-platform/resources/testing/example.js'),
            $asset->url('streams::testing/example.js')
        );
    }

    public function testPath()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            '/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            $asset->path('streams::testing/example.js')
        );
    }

    /**
     * @todo confirm asset() is no longer used directly
     */
    public function testAsset()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            '/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            $asset->asset('streams::testing/example.js')
        );
    }

    public function testScript()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
            $asset->script('streams::testing/example.js', ['foo' => 'bar'])
        );
    }

    public function testStyle()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $this->assertStringContainsString(
            '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
            $asset->style('streams::testing/example.css', ['foo' => 'bar'])
        );
    }

    /**
     * @todo check if pluralisation is gone
     */
    public function testScripts()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath('test.js', 'streams::testing/example.js');
        $asset->addPath('test.js', 'streams::testing/example2.js');

        $this->assertTrue(
            in_array($asset->scripts('test.js', ['foo' => 'bar']), [
                '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example.js',
                '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/example2.js',
            ])
        );
    }

    /**
     * @todo check if pluralisation is gone
     */
    public function testStyles()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath('test.css', 'streams::testing/example.css');
        $asset->addPath('test.css', 'streams::testing/example2.css');

        $this->assertStringContainsString(
            [
                '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
                '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example2.css',
            ],
            $asset->styles('test.css', ['foo' => 'bar'])
        );
    }

    /**
     * @todo check if pluralisation is gone
     */
    public function testPaths()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath('test.css', 'streams::testing/example.css');
        $asset->addPath('test.css', 'streams::testing/example2.css');

        $this->assertStringContainsString(
            [
                '/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
                '/app/default/assets/anomaly/streams-platform/resources/testing/example2.css',
            ],
            $asset->paths('test.css', ['foo' => 'bar'])
        );
    }

    /**
     * @todo check if pluralisation is gone
     */
    public function testUrls()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath('test.css', 'streams::testing/example.css');
        $asset->addPath('test.css', 'streams::testing/example2.css');

        $this->assertStringContainsString(
            [
                url(
                    'app/default/assets/anomaly/streams-platform/resources/testing/example.css'
                ),
                url(
                    'app/default/assets/anomaly/streams-platform/resources/testing/example2.css'
                ),
            ],
            $asset->urls('test.css')
        );
    }

    /**
     * @todo check if pluralisation is gone
     */
    public function testInlines()
    {
        $this->markTestIncomplete();
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath('test.css', 'streams::testing/example.css');
        $asset->addPath('test.css', 'streams::testing/example2.css');

        $this->assertStringContainsString(
            [
                file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
                file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example2.css')),
            ],
            $asset->inlines('test.css', ['foo' => 'bar'])
        );
    }

    public function testAddPath()
    {
        /* @var \Anomaly\Streams\Platform\Asset\AssetManager $asset */
        $asset = app(\Anomaly\Streams\Platform\Asset\AssetManager::class);

        $asset->addPath(
            'testing',
            base_path('vendor/anomaly/streams-platform/resources/testing')
        );

        $this->assertStringContainsString(
            base_path('vendor/anomaly/streams-platform/resources/testing/example.css'),
            $asset->real('testing::example.css')
        );
    }
}
