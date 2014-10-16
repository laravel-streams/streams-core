<?php namespace Streams\Platform\Asset;

class AddonTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanSetAndGetPath()
    {
        $addon = $this->stub();

        $this->assertEquals('foo/bar', $addon->setPath('foo/bar')->getPath());
    }

    public function testItCanDetermineIfCoreAddonOrNot()
    {
        $addon = $this->stub();

        $this->assertEquals(false, $addon->setPath('addons/shared/foo/bar')->isCore());
        $this->assertEquals(true, $addon->setPath('core/addons/foo/bar')->isCore());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\AddonPresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\AddonServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Addon(app());
    }
}
