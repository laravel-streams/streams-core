<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Facades\Images;

/**
 * Class ImageManagerTest
 */
class ImageManagerTest extends TestCase
{
    public function testCanMakeImageInstances()
    {
        $this->assertInstanceOf(Image::class, Images::make('test'));
    }

    public function testNamedImages()
    {
        $this->assertEquals(
            'streams::testing/cat.jpg',
            Images::register('example', 'streams::testing/cat.jpg')->resolve('example')
        );

        $this->assertEquals(
            '/vendor/anomaly/streams-platform/resources/testing/cat.jpg',
            Images::register('example', 'streams::testing/cat.jpg')
                ->make('example')
                ->path()
        );
    }

    public function testRegisteredPaths()
    {
        Images::addPath(
            'testing',
            base_path('vendor/anomaly/streams-platform/resources/testing')
        );

        $this->assertSame(
            '/vendor/anomaly/streams-platform/resources/testing/cat.jpg',
            Images::make('testing::cat.jpg')->path()
        );
    }
}
