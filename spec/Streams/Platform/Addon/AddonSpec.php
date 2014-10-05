<?php

namespace spec\Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddonSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Addon');
    }

    function it_returns_false_if_not_core()
    {
        $this->setPath('addons/shared/modules/foo')->isCore()->shouldReturn(false);
    }

    function it_returns_true_if_is_core()
    {
        $this->setPath('core/addons/modules/foo')->isCore()->shouldReturn(true);
    }

    function it_can_get_type()
    {
        $this->getType()->shouldReturn('addon');
    }

    function it_can_get_slug()
    {
        $this->getSlug()->shouldReturn('abstract');
    }

    function it_can_set_and_get_path()
    {
        $this->setPath('foo/bar')->getPath()->shouldReturn('foo/bar');
    }

    function it_can_get_path_with_path_appended()
    {
        $this->setPath('foo/bar')->getPath('baz')->shouldReturn('foo/bar/baz');
    }

    function it_can_get_abstract()
    {
        $this->getAbstract()->shouldReturn('streams.addon.abstract');
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\AddonPresenter');
    }

    function it_can_return_new_service_provider()
    {
        $this->newServiceProvider()->shouldHaveType('Streams\Platform\Addon\AddonServiceProvider');
    }
}
