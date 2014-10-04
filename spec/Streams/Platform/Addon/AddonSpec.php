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

    function it_can_set_and_get_type()
    {
        $this->setType('addon')->getType()->shouldReturn('addon');
    }

    function it_can_set_and_get_slug()
    {
        $this->setSlug('test')->getSlug()->shouldReturn('test');
    }

    function is_can_set_and_get_path()
    {
        $this->setPath('foo/bar')->getPath()->shouldReturn('foo/bar');
    }

    function is_can_get_path_with_path_appended()
    {
        $this->setPath('foo/bar')->getPath('baz')->shouldReturn('foo/bar/baz');
    }
}
