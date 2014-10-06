<?php

namespace spec\Streams\Platform\Addon;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Illuminate\Foundation\Application;
use Streams\Platform\Addon\Addon;
use Prophecy\Argument;

class AddonPresenterSpec extends LaravelObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Addon(new Application()));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\AddonPresenter');
    }

    function it_can_return_addon_name()
    {
        $this->name()->shouldReturn('addon.abstract::addon.name');
    }

    function it_can_return_addon_slug()
    {
        $this->slug()->shouldReturn('abstract');
    }
}
