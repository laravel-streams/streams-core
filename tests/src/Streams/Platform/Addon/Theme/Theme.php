<?php namespace Streams\Platform\Asset\Theme;

class ThemeTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsATheme()
    {
        $addon = $this->stub();

        $this->assertEquals('theme', $addon->getType());
    }

    public function testItCanGetAdminFlag()
    {
        $addon = $this->stub();

        $this->assertEquals(false, $addon->isAdmin());
    }

    public function testItCanSetAndGetActiveFlag()
    {
        $addon = $this->stub();

        $this->assertEquals(true, $addon->setActive(true)->isActive());
    }

    public function testItCanReturnNewTag()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Theme\ThemeTag';
        $actual   = get_class($addon->newTag());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Theme\ThemePresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\Theme\ThemeServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\Theme\ThemeAddon(app());
    }
}
