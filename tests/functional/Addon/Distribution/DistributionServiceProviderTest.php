<?php namespace Streams\Platform\Addon\Distribution;

class DistributionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersDistributionsToContainer()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distribution.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesDistributionsToCollection()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distributions')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 