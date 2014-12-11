<?php namespace Anomaly\Streams\Platform\Asset;

class ImageTest extends \PHPUnit_Framework_TestCase
{

    protected static $image;

    public static function setUpBeforeClass()
    {
        self::$image = (new Image())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../resources');
    }

    public function testItCanBeSetUp()
    {
        $image = self::$image;

        $image->setPublish(true)
            ->setDirectory(__DIR__ . '/../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../resources');

        $this->assertTrue(true);
    }

    public function testItCanMakeANewInstance()
    {
        $image = self::$image;

        $image2 = $image->make('phpunit::img/foo.jpg');

        $this->assertInstanceOf('Anomaly\Streams\Platform\Asset\Image', $image2);
    }

    public function testItCanGetSupportedFilters()
    {
        $image = self::$image;

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

    public function testItCanReturnThePathToAnImage()
    {
        $image = self::$image;

        $expected = 'assets/default/531ab41e9642a44995e5044c8c80653c.jpg';
        $actual   = $image->path('phpunit::img/foo.jpg');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyBlurFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/901874e56e580c00218553951139f913.jpg';
        $actual   = $image->blur(10)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '1cfcb0ea2f7e72a1e48724f96e6382bd';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyBrightnessFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/112bfa7af22811f4aff28e44dc1ae4b6.jpg';
        $actual   = $image->brightness(-100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '63a176e85094e78cd686b263acc39f7a';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyColorizeFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/12d58a29f05713c9ef02cd389455fba0.jpg';
        $actual   = $image->colorize(-100, +100, -100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'abe99af6a96e24025dfea628654ada20';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyContrastFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/27caeb9476e55d061548694306b5da89.jpg';
        $actual   = $image->contrast(-100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '3f6d251df7b48f6a830e6f79244cc124';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyCropFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/b80af147cff11ca01f6a0d067255d5f9.jpg';
        $actual   = $image->crop(5, 10, 0, 0)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '99a969c7d036f45709bdbb7a1c45a48f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyFitFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/4fa613ad9c2dfd34f5391354967295b4.jpg';
        $actual   = $image->fit(10, 5)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '0cf62d210396063d917872087de78cec';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyFlipFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/ac0655565c8733994ccf39662040c1de.jpg';
        $actual   = $image->flip('h')->path('phpunit::img/bar.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '7242e8157d851fc1e8b621a22bfe8fa3';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyGammaFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/4f58f3d34b71b3b5c4a3019f04de3ba2.jpg';
        $actual   = $image->gamma(+100)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '9a04781f38436c0915f9a22e086e843f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyGreyscaleFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/d7cad53d0b2f0f5cf2d69796200b3c35.jpg';
        $actual   = $image->greyscale()->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'dd95f06c304d85202c86269e8514470d';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyHeightenFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/99fa77f090615032fc502a447f3f43da.jpg';
        $actual   = $image->heighten(20)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'a7c41103c32eef0092f1d153ce14dfd7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyInvertFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/65770119082e7d2e47598a90bad9ef20.jpg';
        $actual   = $image->invert()->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '4fd00d9c1f4cd62c15e779a2af744ad7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitColorsFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/46c6c7786ad5a009d5e68dc4c50d1fb9.jpg';
        $actual   = $image->limitColors(1)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'eba6b312f8cad4e26e7cf054dc0a9a95';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyPixelateFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/ea7e4850f9f5a6c93688db6afd73addf.jpg';
        $actual   = $image->pixelate(2)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '2ee518203fc2faaeefc6b0e8ba16b68a';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyOpacityFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/048f4cacc2fa759ccc68412330c9ec1d.png';
        $actual   = $image->opacity(30)->path('phpunit::img/foo.png');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '2b91e451971dcf589b4fe9fe6e8d5578';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyQualityFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/d5bc409e27ff6e728b003204c5fb492b.jpg';
        $actual   = $image->quality(10)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '9a04781f38436c0915f9a22e086e843f';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyResizeFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/53399401dfdb885147d454fd8b0057db.jpg';
        $actual   = $image->resize(30, 5)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = '959246aa4f817e31fa5d4251ee03d640';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyLimitRotateFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/30b804d7e4419d212c7838a3c7fff5e0.jpg';
        $actual   = $image->rotate(45)->path('phpunit::img/bar.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'd0d1da8fcdcdf3dc6c70dcfa7996ef7b';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    public function testItCanApplyWidenFilter()
    {
        $image = self::$image;

        $expected = 'assets/default/560f3ed874005ea9cd6aad1517b959de.jpg';
        $actual   = $image->widen(20)->path('phpunit::img/foo.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../public/' . $expected;

        $expected = 'a7c41103c32eef0092f1d153ce14dfd7';
        $actual   = md5(file_get_contents($target));

        // Make sure the filter modified the image.
        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return (new \Anomaly\Streams\Platform\Asset\Image())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../resources');
    }
}
