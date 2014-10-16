<?php namespace Streams\Platform\Asset;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanGetSupportedFilters()
    {
        $image = $this->stub();

        $expected = [
            'blur',
            'brightness',
            'colorize',
            'contrast',
            'crop',
            'encode',
            'fit',
            'flip',
            'gamma',
            'greyscale',
            'heighten',
            'invert',
            'limitColors',
            'pixelate',
            'opacity',
            'resize',
            'rotate',
            'amount',
            'widen',
        ];
        $actual   = $image->getSupportedFilters();

        $this->assertEquals($expected, $actual);
    }

    public function testItCanMakeAnInstance()
    {
        $image = $this->stub();

        $this->assertTrue($image->make('phpunit::img/foo.jpg') instanceof \Streams\Platform\Asset\Image);
    }

    public function testItCanReturnThePathToAnImage()
    {
        $image = $this->stub();

        $expected = 'assets/default/c334158374df749a9e937b88a43b6b39.jpg';
        $actual   = $image->path('phpunit::img/foo.jpg');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyBlurFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/5899d28bbbdcadf35d72e34b623bba5a.jpg';
        $actual   = $image->blur(10)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '1cfcb0ea2f7e72a1e48724f96e6382bd';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyBrightnessFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/489985ea06158a5b3a6c6554b84f678a.jpg';
        $actual   = $image->brightness(-100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '63a176e85094e78cd686b263acc39f7a';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyColorizeFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/43750e0edb121db17f55620beb32c540.jpg';
        $actual   = $image->colorize(-100, +100, -100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'abe99af6a96e24025dfea628654ada20';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyContrastFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/0d263700c754e502617f3db95f82efb8.jpg';
        $actual   = $image->contrast(-100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '3f6d251df7b48f6a830e6f79244cc124';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyCropFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/95e3ce02f3df3ff4888c8aa0c3282211.jpg';
        $actual   = $image->crop(5, 10, 0, 0)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '99a969c7d036f45709bdbb7a1c45a48f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyFitFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/6f52ce665f95ae0ba0ca85cb79e63c95.jpg';
        $actual   = $image->fit(10, 5)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '0cf62d210396063d917872087de78cec';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyFlipFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/bebfd4230221f09293a342383f732adf.jpg';
        $actual   = $image->flip('h')->path('phpunit::img/bar.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '7242e8157d851fc1e8b621a22bfe8fa3';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyGammaFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/a5aacf4ef996f7f0c716532446d3e60a.jpg';
        $actual   = $image->gamma(+100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '9a04781f38436c0915f9a22e086e843f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyGreyscaleFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/98119144c426130590f7c12ada711494.jpg';
        $actual   = $image->greyscale()->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'dd95f06c304d85202c86269e8514470d';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyHeightenFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/189aef6b63872c15f6c0f83d9143176c.jpg';
        $actual   = $image->heighten(20)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'a7c41103c32eef0092f1d153ce14dfd7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyInvertFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/e64410320ea7028ade38c427fdcf9268.jpg';
        $actual   = $image->invert()->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '4fd00d9c1f4cd62c15e779a2af744ad7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitColorsFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/7f39cb0b2ef73709f7fc892287d590a0.jpg';
        $actual   = $image->limitColors(1)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'eba6b312f8cad4e26e7cf054dc0a9a95';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitPixelateFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/3ee2b33b7c2ec7b8879a3d3684cdda17.jpg';
        $actual   = $image->pixelate(2)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '2ee518203fc2faaeefc6b0e8ba16b68a';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitOpacityFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/c8b2a6fc9456f5197cf458b12d1ecf3a.png';
        $actual   = $image->opacity(30)->path('phpunit::img/foo.png');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '2b91e451971dcf589b4fe9fe6e8d5578';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyQualityFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/567491df37e818f5a5f5f76c05ba1c9e.jpg';
        $actual   = $image->quality(10)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '9a04781f38436c0915f9a22e086e843f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitResizeFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/ca0055b8e277437d455affd92b393e6d.jpg';
        $actual   = $image->resize(30, 5)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '959246aa4f817e31fa5d4251ee03d640';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitRotateFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/103ae43d4a5b9b2fd37860be2bffefd1.jpg';
        $actual   = $image->rotate(45)->path('phpunit::img/bar.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'd0d1da8fcdcdf3dc6c70dcfa7996ef7b';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitWidenFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/a88905e87506f0703bd8c5b7a9e343e9.jpg';
        $actual   = $image->widen(20)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = 'a7c41103c32eef0092f1d153ce14dfd7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Image())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../../../resources');
    }
}
