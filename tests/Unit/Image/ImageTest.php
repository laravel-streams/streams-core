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

    public function testPicture()
    {
        $this->markTestIncomplete();

        $this->assertEquals(
            '<img  src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->picture()
        );

        $this->assertEquals(
            '<img  src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::register('cat', 'streams::testing/cat.jpg')->make('cat')->img()
        );
    }

    public function testEncode()
    {
        $this->assertTrue(
            str_is(
                '<img  src="/vendor/anomaly/streams-platform/resources/testing/*.png" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->encode('png')->img()
            )
        );
    }

    public function testBase64()
    {
        $this->assertTrue(
            str_is(
                'data:image/jpg*',
                Images::make('streams::testing/cat.jpg')->base64()
            )
        );
    }

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

    public function testInline()
    {
        $this->assertTrue(
            str_is(
                '<img  src="data:image/jpg*" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->inline()
            )
        );
    }

    public function testCss()
    {
        $this->assertEquals(
            'url(/vendor/anomaly/streams-platform/resources/testing/cat.jpg)',
            Images::make('streams::testing/cat.jpg')->css()
        );
    }

    public function testData()
    {
        $this->markTestIncomplete();

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/cat.jpg')),
            Images::make('streams::testing/cat.jpg')->data()
        );
    }
}
