<?php


use Illuminate\Support\Str;
use Streams\Core\Image\Image;
use Streams\Core\Support\Facades\Images;

/**
 * @todo complete tests
 *
 * Class ImageTest
 */
class ImageTest extends StreamsTestCase
{

    public function testAlterationsPassThroughCall()
    {
        $this->markTestIncomplete();

        $this->assertEquals(
            ['greyscale' => []],
            Images::make('streams::testing/cat.jpg')->greyscale()->getAlterations()
        );
    }

    public function testMacrosPassThroughCall()
    {
        $this->markTestIncomplete();
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
        $this->markTestIncomplete();
        $this->assertEquals(
            ['width' => '100%'],
            Images::make('streams::testing/cat.jpg')->width('100%')->getPrototypeAttributes()
        );
    }

    public function testToStringMethod()
    {
        $this->markTestIncomplete();
        $this->assertSame(
            '<img src="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg" alt="Cat">',
            (string) Images::make('streams::testing/cat.jpg')
        );
    }

    public function testImgOutput()
    {
        $this->markTestIncomplete();
        $this->assertEquals(
            '<img src="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->img()
        );

        $this->assertEquals(
            '<img src="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg" alt="Cat">',
            Images::register('cat', 'streams::testing/cat.jpg')->make('cat')->img()
        );
    }

    public function testPictureOutput()
    {
        $this->markTestIncomplete();
        $this->assertSame(
            '<picture>
<source media="(min-width: 1000px)" srcset="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg">
<source media="(min-width: 800px)" srcset="/vendor/anomaly/streams-platform/_streams/testing/a6a12235c5b0ddea5d2caf6b306dd5df.jpg">
<source media="(max-width: 799px)" srcset="/vendor/anomaly/streams-platform/_streams/testing/d77fa15955caa3616dac5d789f8ee888.jpg">
<img src="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg" alt="Cat">
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
        $this->markTestIncomplete();
        $this->assertTrue(
            Str::is(
                'data:image/jpg*',
                Images::make('streams::testing/cat.jpg')->base64()
            )
        );
    }

    public function testUrlOutput()
    {
        $this->markTestIncomplete();
        $this->assertEquals(
            url('vendor/anomaly/streams-platform/_streams/testing/cat.jpg'),
            Images::make('streams::testing/cat.jpg')->url()
        );
    }

    public function testPathOutput()
    {
        $this->markTestIncomplete();
        $this->assertEquals(
            '/vendor/anomaly/streams-platform/_streams/testing/cat.jpg',
            Images::make('streams::testing/cat.jpg')->path()
        );
    }

    public function testInlineOutput()
    {
        $this->markTestIncomplete();
        $this->assertTrue(
            Str::is(
                '<img src="data:image/jpg*" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->inline()
            )
        );
    }

    public function testCssOutput()
    {
        $this->markTestIncomplete();
        $this->assertEquals(
            'url(/vendor/anomaly/streams-platform/_streams/testing/cat.jpg)',
            Images::make('streams::testing/cat.jpg')->css()
        );
    }

    public function testDataOutput()
    {
        $this->markTestIncomplete();
        // @todo data doesn't match. Meta/EXIF changes?
        $this->markTestIncomplete();

        $this->assertStringContainsString(
            file_get_contents(base_path('vendor/anomaly/streams-platform/_streams/testing/cat.jpg')),
            Images::make('streams::testing/cat.jpg')->data()
        );
    }

    public function testSrcsets()
    {
        $this->markTestIncomplete();
        $this->assertSame(
            '<img src="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg" srcset="/vendor/anomaly/streams-platform/_streams/testing/cat.jpg 1000w, /vendor/anomaly/streams-platform/_streams/testing/a6a12235c5b0ddea5d2caf6b306dd5df.jpg 800w, /vendor/anomaly/streams-platform/_streams/testing/d77fa15955caa3616dac5d789f8ee888.jpg 400w" alt="Cat">',
            Images::make('streams::testing/cat.jpg')->srcsets([
                '1000w' => Images::make('streams::testing/cat.jpg'),
                '800w' => Images::make('streams::testing/cat.jpg')->resize(800),
                '400w' => Images::make('streams::testing/cat.jpg')->resize(400),
            ])->img()
        );
    }

    public function testCanChangeEncoding()
    {
        $this->markTestIncomplete();
        $this->assertTrue(
            Str::is(
                '<img src="/vendor/anomaly/streams-platform/_streams/testing/*.png" alt="Cat">',
                Images::make('streams::testing/cat.jpg')->encode('png')->img()
            )
        );
    }

    public function testCanChangeOutputQuality()
    {
        $this->markTestIncomplete();
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
