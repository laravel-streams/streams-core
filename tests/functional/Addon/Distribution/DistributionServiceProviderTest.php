<?php namespace Streams\Platform\Addon\Distribution;

class DistributionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();
    }

    public function testItRegistersDistributionsToContainer()
    {
        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distribution.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesDistributionsToCollection()
    {
        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distributions')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItRegistersTheApplicationDistributionToContainer()
    {
        $expected = 'Streams\Addon\Distribution\Testable\TestableDistribution';
        $actual   = app('streams.distribution')->getResource();

        $this->assertInstanceOf($expected, $actual);
    }
}
 