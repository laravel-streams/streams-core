<?php namespace spec\Streams\Platform\Addon\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemeRepository');
    }
}