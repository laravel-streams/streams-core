<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Theme\ThemeServiceProvider;

class DistributionServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersDistributionsToContainer()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distribution.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesDistributionsToCollection()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Distribution\DistributionPresenter';
        $actual   = app('streams.distributions')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItRegistersTheApplicationDistributionToContainer()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Addon\Distribution\Testable\TestableDistribution';
        $actual   = app('streams.distribution')->getResource();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItCanGetAdminTheme()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $provider = new ThemeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Addon\Theme\Testable\TestableTheme';
        $actual   = app('streams.distribution')->getAdminTheme()->getResource();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItCanGetPublicTheme()
    {
        $provider = new DistributionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $provider = new ThemeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Addon\Theme\Testable\TestableTheme';
        $actual   = app('streams.distribution')->getPublicTheme()->getResource();

        $this->assertInstanceOf($expected, $actual);
    }
}
 