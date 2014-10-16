<?php namespace Streams\Platform\Asset;

class AddonCollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanFindBySlug()
    {
        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = get_class(app('streams.distributions')->findBySlug('base'));

        $this->assertEquals($expected, $actual);
    }
}
