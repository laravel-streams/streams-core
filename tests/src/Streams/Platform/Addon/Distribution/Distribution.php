<?php namespace Streams\Platform\Asset\Distribution;

class DistributionTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsADistribution()
    {
        $addon = $this->stub();

        $this->assertEquals('distribution', $addon->getType());
    }

    public function testItCanGetAdminTheme()
    {
        $addon = $this->stub();

        $this->assertEquals('streams', $addon->getAdminTheme());
    }

    public function testItCanGetPublicTheme()
    {
        $addon = $this->stub();

        $this->assertEquals('streams', $addon->getPublicTheme());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Distribution\DistributionServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    public function testItRegistersStreamsDistribution()
    {
        $this->stub()->newServiceProvider()->register();

        $distribution = app('streams.distribution');

        $this->assertTrue($distribution instanceof \Streams\Platform\Addon\Distribution\DistributionPresenter);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Distribution\DistributionAddon(app());
    }
}
