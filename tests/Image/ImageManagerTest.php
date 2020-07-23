<?php


use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Facades\Images;

/**
 * @todo complete tests
 *
 * Class ImageManagerTest
 */
class ImageManagerTest extends StreamsTestCase
{
    /**
     * @todo determine how to test assets in package
     */
    public function testCanMakeImageInstances()
    {
        $this->assertInstanceOf(Image::class, Images::make('test'));
    }

    public function testNamedImages()
    {
        $this->markTestIncomplete();

        $this->assertEquals(
            'streams::testing/cat.jpg',
            Images::register('example', 'streams::testing/cat.jpg')->resolve('example')
        );

        $this->assertEquals(
            '/vendor/anomaly/streams-platform/_streams/testing/cat.jpg',
            Images::register('example', 'streams::testing/cat.jpg')
                ->make('example')
                ->path()
        );
    }

    public function testRegisteredPaths()
    {
        $this->markTestIncomplete();

        Images::addPath(
            'testing',
            base_path('vendor/anomaly/streams-platform/_streams/testing')
        );

        $this->assertSame(
            '/vendor/anomaly/streams-platform/_streams/testing/cat.jpg',
            Images::make('testing::cat.jpg')->path()
        );
    }
}
