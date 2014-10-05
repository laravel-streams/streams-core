<?php

namespace spec\Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use Streams\Platform\Addon\Addon;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddonPresenterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new Addon(new Application()));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\AddonPresenter');
    }

    function it_can_return_addon_slug()
    {
        $this->slug()->shouldReturn('abstract');
    }
}
