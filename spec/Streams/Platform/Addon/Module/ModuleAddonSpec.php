<?php

namespace spec\Streams\Platform\Addon\Module;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleAddonSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleAddon');
    }

    function it_can_get_nav()
    {
        $this->getNav()->shouldReturn(null);
    }

    function it_can_set_and_get_menu()
    {
        $this->setMenu(['foo'])->getMenu()->shouldReturn(['foo']);
    }

    function it_can_set_and_get_sections()
    {
        $this->setSections(['foo'])->getSections()->shouldReturn(['foo']);
    }

    function it_can_get_active_section()
    {
        $_SERVER['REQUEST_URI'] = 'admin/foo/bar';

        $this->setSections([['url' => 'admin/foo']])->getActiveSection()->shouldReturn(['url' => 'admin/foo']);
    }

    function it_returns_null_if_no_active_section()
    {
        $this->getActiveSection()->shouldReturn(null);
    }

    function it_can_set_and_get_installed_state()
    {
        $this->setInstalled(true)->isInstalled()->shouldReturn(true);
    }

    function it_can_set_and_get_enabled_state()
    {
        $this->setEnabled(true)->isEnabled()->shouldReturn(true);
    }

    function it_can_return_new_tag()
    {
        $this->newTag()->shouldHaveType('Streams\Platform\Addon\Module\ModuleTag');
    }

    function it_can_return_new_model()
    {
        $this->newModel()->shouldHaveType('Streams\Platform\Addon\Module\ModuleModel');
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\Module\ModulePresenter');
    }

    function it_can_return_new_installer()
    {
        $this->newInstaller()->shouldHaveType('Streams\Platform\Addon\Module\ModuleInstaller');
    }

    function it_can_return_new_service_provider()
    {
        $this->newServiceProvider()->shouldHaveType('Streams\Platform\Addon\Module\ModuleServiceProvider');
    }
}
