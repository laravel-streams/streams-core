<?php namespace Streams\Platform\Addon\Block;

class BlockServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new BlockServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();
    }

    public function testItRegistersBlocksToContainer()
    {
        $expected = 'Streams\Platform\Addon\Block\BlockPresenter';
        $actual   = app('streams.block.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesBlocksToCollection()
    {
        $expected = 'Streams\Platform\Addon\Block\BlockPresenter';
        $actual   = app('streams.blocks')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 