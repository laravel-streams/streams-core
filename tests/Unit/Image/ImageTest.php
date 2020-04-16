<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Image\Facades\Images;

/**
 * Class ImageTest
 */
class ImageTest extends TestCase
{

    public function testImg()
    {
        $this->assertEquals(
            '<img  src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->img()
        );

        $this->assertEquals(
            '<img  src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::register('cat', 'streams::testing/cat.jpg')->make('cat')->img()
        );
    }

    // public function testInline()
    // {
    //     $this->assertEquals(
    //         file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/cat.jpg')),
    //         Images::make('streams::testing/cat.jpg')->data()
    //     );

    //     $this->assertStringContainsString(
    //         file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
    //         Images::inline('streams::testing/example.css')
    //     );
    // }

    public function testUrl()
    {
        $this->assertEquals(
            url('vendor/anomaly/streams-platform/resources/testing/cat.jpg'),
            Images::make('streams::testing/cat.jpg')->url()
        );
    }

    public function testPath()
    {
        $this->assertEquals(
            '/vendor/anomaly/streams-platform/resources/testing/cat.jpg',
            Images::make('streams::testing/cat.jpg')->path()
        );
    }
}
