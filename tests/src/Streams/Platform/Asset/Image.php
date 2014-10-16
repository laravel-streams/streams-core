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

    public function testItCanApplyAFilter()
    {
        $image = $this->stub();

        $expected = 'assets/default/40b6b74cac9499e2f25557ac98b3ff01.jpg';
        $actual   = $image->setImage('phpunit::img/foo.jpg')->resize(1, 1)->path();

        $this->assertEquals($expected, $actual);
    }

    public function testItCanBlurAnImage()
    {
        $image = $this->stub();

        $expected = 'assets/default/4ab2464a0bcc6156ad7cd8c64a9314ec.jpg';
        $actual   = $image->blur(10)->path('phpunit::img/bar.jpg');

        // Make sure the path is correct.
        $this->assertEquals($expected, $actual);

        $target = __DIR__ . '/../../../../public/' . $expected;

        $expected = '1cfcb0ea2f7e72a1e48724f96e6382bd';
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
