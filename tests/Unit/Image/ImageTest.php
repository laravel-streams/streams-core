<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Image\Facades\Images;

/**
 * Class ImageTest
 */
class ImageTest extends TestCase
{

    public function testAlterationsPassThroughCall()
    {
        $this->assertEquals(
            ['greyscale' => []],
            Images::make('streams::testing/cat.jpg')->greyscale()->getAlterations()
        );
    }

    public function testMacrosPassThroughCall()
    {
        Image::macro('test', function () {
            return 'foo.bar';
        });

        $this->assertEquals(
            'foo.bar',
            Images::make('streams::testing/cat.jpg')->test()
        );
    }

    public function testAttributesPassThroughCall()
    {
        $this->assertEquals(
            ['width' => '100%'],
            Images::make('streams::testing/cat.jpg')->width('100%')->getAttributes()
        );
    }

    public function testToStringMethod()
    {
        $this->assertSame(
            '<img src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            (string) Images::make('streams::testing/cat.jpg')
        );
    }

    public function testImgOutput()
    {
        $this->assertEquals(
            '<img src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->img()
        );

        $this->assertEquals(
            '<img src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">',
            Images::register('cat', 'streams::testing/cat.jpg')->make('cat')->img()
        );
    }

    public function testPictureOutput()
    {
        $this->assertSame(
            '<picture>
<source media="(min-width: 1000px)" srcset="/vendor/anomaly/streams-platform/resources/testing/cat.jpg">
<source media="(min-width: 800px)" srcset="/vendor/anomaly/streams-platform/resources/testing/a6a12235c5b0ddea5d2caf6b306dd5df.jpg">
<source media="(max-width: 799px)" srcset="/vendor/anomaly/streams-platform/resources/testing/d77fa15955caa3616dac5d789f8ee888.jpg">
<img src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" alt="Cat">
</picture>',
            Images::make('streams::testing/cat.jpg')->sources([
                Images::make('streams::testing/cat.jpg')->media('(min-width: 1000px)'),
                Images::make('streams::testing/cat.jpg')->resize(800)->media('(min-width: 800px)'),
                Images::make('streams::testing/cat.jpg')->resize(400)->media('(max-width: 799px)'),
            ])->picture()
        );
    }

    public function testBase64Output()
    {
        $this->assertTrue(
            str_is(
                'data:image/jpg*',
                Images::make('streams::testing/cat.jpg')->base64()
            )
        );
    }

    public function testUrlOutput()
    {
        $this->assertEquals(
            url('vendor/anomaly/streams-platform/resources/testing/cat.jpg'),
            Images::make('streams::testing/cat.jpg')->url()
        );
    }

    public function testPathOutput()
    {
        $this->assertEquals(
            '/vendor/anomaly/streams-platform/resources/testing/cat.jpg',
            Images::make('streams::testing/cat.jpg')->path()
        );
    }

    public function testInlineOutput()
    {
        $this->assertTrue(
            str_is(
                '<img src="data:image/jpg*" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->inline()
            )
        );
    }

    public function testCssOutput()
    {
        $this->assertEquals(
            'url(/vendor/anomaly/streams-platform/resources/testing/cat.jpg)',
            Images::make('streams::testing/cat.jpg')->css()
        );
    }

    public function testDataOutput()
    {
        // @todo data doesn't match. Meta/EXIF changes?
        $this->markTestIncomplete();

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/resources/testing/cat.jpg')),
            Images::make('streams::testing/cat.jpg')->data()
        );
    }

    public function testSrcsets()
    {
        $this->assertSame(
            '<img src="/vendor/anomaly/streams-platform/resources/testing/cat.jpg" srcset="/vendor/anomaly/streams-platform/resources/testing/cat.jpg 1000w, /vendor/anomaly/streams-platform/resources/testing/a6a12235c5b0ddea5d2caf6b306dd5df.jpg 800w, /vendor/anomaly/streams-platform/resources/testing/d77fa15955caa3616dac5d789f8ee888.jpg 400w" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->srcsets([
                '1000w' => Images::make('streams::testing/cat.jpg'),
                '800w' => Images::make('streams::testing/cat.jpg')->resize(800),
                '400w' => Images::make('streams::testing/cat.jpg')->resize(400),
            ])->img()
        );
    }

    public function testCanChangeEncoding()
    {
        $this->assertTrue(
            str_is(
                '<img src="/vendor/anomaly/streams-platform/resources/testing/*.png" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->encode('png')->img()
            )
        );
    }

    public function testCanChangeOutputQuality()
    {
        $this->assertNotSame(
            md5(Images::make('streams::testing/cat.jpg')->setQuality(80)->data()),
            md5(Images::make('streams::testing/cat.jpg')->setQuality(100)->data())
        );
    }

    public function testCanVersionOutput()
    {
        $this->markTestIncomplete();
        $this->assertNotSame(
            md5(Images::make('streams::testing/cat.jpg')->setQuality(80)->data()),
            md5(Images::make('streams::testing/cat.jpg')->setQuality(100)->data())
        );
    }
}
