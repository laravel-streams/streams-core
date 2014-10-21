<?php namespace Anomaly\Streams\Platform\Addon\Module;

class ModuleInstallerTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanGetInstallers()
    {
        $installer = new ModuleInstaller();

        $this->assertEmpty($installer->getInstallers());
    }

    public function testItCanInstallModule()
    {
        /*$module = app('streams.module.testable');

        $service = new ModuleService(app());

        $service->install($module);*/

        $this->assertTrue(false);
    }

    public function testItCanUninstallModule()
    {
        /*$module = app('streams.module.testable');

        $service = new ModuleService(app());

        $service->uninstall($module);*/

        $this->assertTrue(false);
    }

    public function testItDefaultsToModuleInstallerIfInstallerDoesNotExist()
    {
        /*$module = app('streams.module.no_installer');

        $service = new ModuleService(app());

        $service->uninstall($module);*/

        $this->assertTrue(false);
    }
}
 