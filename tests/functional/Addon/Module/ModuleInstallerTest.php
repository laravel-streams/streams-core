<?php namespace Streams\Platform\Addon\Module;

class ModuleInstallerTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanGetInstallers()
    {
        $installer = new ModuleInstaller();

        $this->assertEmpty($installer->getInstallers());
    }
}
 