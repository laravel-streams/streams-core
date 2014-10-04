<?php

namespace spec\Streams\Platform\Addon;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Addon');
    }

    function it_can_determine_if_is_core()
    {
        $this->setPath('core/addons/modules/foo')->isCore()->shouldReturn(true);
        $this->setPath('addons/shared/modules/foo')->isCore()->shouldReturn(false);
    }

    function it_can_set_and_get_type()
    {
        $this->setType('addon')->getType()->shouldReturn('addon');
    }

    function it_can_set_and_get_slug()
    {
        $this->setSlug('test')->getSlug()->shouldReturn('test');
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
        $this->setType('foo')->setSlug('bar')->getAbstract()->shouldReturn('streams.foo.bar');
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\AddonPresenter');
    }
}
