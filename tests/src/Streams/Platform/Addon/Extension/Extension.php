<?php namespace Streams\Platform\Asset\Extension;

class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsAExtension()
    {
        $addon = $this->stub();

        $this->assertEquals('extension', $addon->getType());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Extension\ExtensionPresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Extension\ExtensionServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Extension\ExtensionAddon(app());
    }
}
