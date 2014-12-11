<?php namespace Anomaly\Streams\Platform\Addon\Module;

class ModuleAddonTest extends \PHPUnit_Framework_TestCase
{

    protected static $module;

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();

        $provider = new ModuleServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        self::$module = app('streams.module.testable');
    }

    public function testItCanGetNavigation()
    {
        $module = self::$module;

        $this->assertNull($module->getNavigation());
    }

    public function testItCanGetMenu()
    {
        $module = self::$module;

        $this->assertEmpty($module->getMenu());
    }

    public function testItCanGetSections()
    {
        $module = self::$module;

        $this->assertEmpty($module->getSections());
    }

    public function testItCanSetAndGetInstalled()
    {
        $module = self::$module;

        $this->assertTrue($module->setInstalled(true)->isInstalled());
    }

    public function testItCanSetAndGetEnabled()
    {
        $module = self::$module;

        $this->assertTrue($module->setEnabled(true)->setInstalled(true)->isEnabled());
    }

    public function testItCanSetAndGetActive()
    {
        $module = self::$module;

        $this->assertTrue($module->setActive(true)->isActive());
    }

    public function testItCanReturnNewTag()
    {
        $module = self::$module;

        $expected = 'Anomaly\Streams\Platform\Addon\Module\ModuleTag';
        $actual   = $module->newTag();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItCanReturnNewPresenter()
    {
        $module = self::$module;

        $expected = 'Anomaly\Streams\Platform\Addon\Module\ModulePresenter';
        $actual   = $module->newPresenter();

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItCanReturnNewInstaller()
    {
        $module = self::$module;

        $expected = 'Anomaly\Streams\Platform\Addon\Module\ModuleInstaller';
        $actual   = $module->newInstaller();

        $this->assertInstanceOf($expected, $actual);
    }
}
 