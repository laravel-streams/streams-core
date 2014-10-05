<?php

namespace spec\Streams\Platform\Addon\Theme;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemeAddonSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_can_return_is_admin()
    {
        $this->isAdmin()->shouldReturn(false);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemeAddon');
    }

    function it_can_return_new_tag()
    {
        $this->newTag()->shouldHaveType('Streams\Platform\Addon\Theme\ThemeTag');
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\Theme\ThemePresenter');
    }

    function it_can_return_new_service_provider()
    {
        $this->newServiceProvider()->shouldHaveType('Streams\Platform\Addon\Theme\ThemeServiceProvider');
    }
}
