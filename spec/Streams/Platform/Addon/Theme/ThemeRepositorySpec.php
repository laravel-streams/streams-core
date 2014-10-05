<?php namespace spec\Streams\Platform\Addon\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemeRepository');
    }

    function it_has_its_type_set_to_block()
    {
        $this->getType()->shouldReturn('theme');
    }
}