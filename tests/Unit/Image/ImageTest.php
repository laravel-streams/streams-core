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

    public function testInline()
    {
        $this->markTestIncomplete();

        // $this->assertStringContainsString(
        //     file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/cat.jpg')),
        //     Images::inline('streams::testing/cat.jpg')
        // );

        // $this->assertStringContainsString(
        //     file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/example.css')),
        //     Images::inline('streams::testing/example.css')
        // );
    }

    // public function testUrl()
    // {
    //     $this->assertStringContainsString(
    //         url('app/default/assets/anomaly/streams-platform/resources/testing/cat.jpg'),
    //         Images::url('streams::testing/cat.jpg')
    //     );
    // }

    // public function testPath()
    // {
    //     $this->assertStringContainsString(
    //         '/app/default/assets/anomaly/streams-platform/resources/testing/cat.jpg',
    //         Images::path('streams::testing/cat.jpg')
    //     );
    // }

    // public function testScript()
    // {
    //     $this->assertStringContainsString(
    //         '<script foo="bar" src="/app/default/assets/anomaly/streams-platform/resources/testing/cat.jpg',
    //         Images::script('streams::testing/cat.jpg', ['foo' => 'bar'])
    //     );
    // }

    // public function testStyle()
    // {
    //     $this->assertStringContainsString(
    //         '<link foo="bar" media="all" type="text/css" rel="stylesheet" href="/app/default/assets/anomaly/streams-platform/resources/testing/example.css',
    //         Images::style('streams::testing/example.css', ['foo' => 'bar'])
    //     );
    // }
}
