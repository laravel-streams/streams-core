<?php namespace Streams\Platform\Asset\Distribution;

class DistributionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanRegisterADistribution()
    {
        $this->stub()->register();

        $expected = 'Streams\Addon\Distribution\Base\BaseDistribution';
        $actual   = get_class(app('streams.distribution.base'));

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Distribution\DistributionServiceProvider(app());
    }
}
