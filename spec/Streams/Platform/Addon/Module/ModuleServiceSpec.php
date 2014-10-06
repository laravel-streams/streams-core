<?php namespace spec\Streams\Platform\Addon\Module;

use Streams\Platform\Addon\Module\ModuleAddon;
use Streams\Platform\Support\EventDispatcher;
use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleServiceSpec extends ObjectBehavior
{
    function let(Application $app, EventDispatcher $dispatcher)
    {
        $this->beConstructedWith($app, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleService');
    }

    function it_can_install_a_module()
    {
        $this->install(new ModuleAddon(new Application()))->shouldReturn(true);
    }

    function it_can_uninstall_a_module()
    {
        $this->uninstall(new ModuleAddon(new Application()))->shouldReturn(true);
    }
}