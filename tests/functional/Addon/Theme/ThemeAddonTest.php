<?php namespace Anomaly\Streams\Platform\Addon\Theme;

class ThemeAddonTest extends \PHPUnit_Framework_TestCase
{
    protected static $theme;

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();

        $provider = new ThemeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        self::$theme = app('streams.theme.testable');
    }

    public function testItCanGetAdmin()
    {
        $theme = self::$theme;

        $this->assertFalse($theme->isAdmin());
    }

    public function testItCanSetAndGetActive()
    {
        $theme = self::$theme;

        $this->assertTrue($theme->setActive(true)->isActive());
    }

    public function testItCanReturnNewTag()
    {
        $theme = self::$theme;

        $expected = 'Anomaly\Streams\Platform\Addon\Theme\ThemeTag';
        $actual   = $theme->newTag();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItCanReturnNewPresenter()
    {
        $theme = self::$theme;

        $expected = 'Anomaly\Streams\Platform\Addon\Theme\ThemePresenter';
        $actual   = $theme->newPresenter();

        $this->assertInstanceOf($expected, $actual);
    }
}
 