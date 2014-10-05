<?php namespace spec\Streams\Platform\Addon\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemeCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemeCollection');
    }
}