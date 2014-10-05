<?php namespace spec\Streams\Platform\Addon\Module;

use Streams\Platform\Addon\Module\Event\ModuleWasUninstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleWasInstalledEvent;
use Streams\Platform\Addon\Module\ModuleAddon;
use Streams\Platform\Addon\Module\ModuleModel;
use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleListenerSpec extends ObjectBehavior
{
    public function let(ModuleModel $module)
    {
        $this->beConstructedWith($module);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleListener');
    }

    function it_will_fire_when_module_was_installed()
    {
        $this->whenModuleWasInstalled(new ModuleWasInstalledEvent(new ModuleAddon(new Application())));
    }

    function it_will_fire_when_module_was_uninstalled()
    {
        $this->whenModuleWasuninstalled(new ModuleWasUninstalledEvent(new ModuleAddon(new Application())));
    }
}