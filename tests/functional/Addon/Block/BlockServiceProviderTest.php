<?php namespace Anomaly\Streams\Platform\Addon\Block;

class BlockServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersBlocksToContainer()
    {
        $provider = new BlockServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Block\BlockPresenter';
        $actual   = app('streams.block.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesBlocksToCollection()
    {
        $provider = new BlockServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Block\BlockPresenter';
        $actual   = app('streams.blocks')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 