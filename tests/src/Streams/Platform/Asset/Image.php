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

    protected function stub()
    {
        return (new \Streams\Platform\Asset\Image())
            ->setPublish(true)
            ->setDirectory(__DIR__ . '/../../../../public/')
            ->addNamespace('phpunit', __DIR__ . '/../../../../resources');
    }
}
