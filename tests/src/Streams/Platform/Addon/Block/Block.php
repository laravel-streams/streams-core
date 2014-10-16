<?php namespace Streams\Platform\Asset\Block;

class BlockTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsABlock()
    {
        $addon = $this->stub();

        $this->assertEquals('block', $addon->getType());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Block\BlockPresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Block\BlockServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Block\BlockAddon(app());
    }
}
