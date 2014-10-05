<?php namespace spec\Streams\Platform\Addon\Theme;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemePresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemePresenter');
    }
}