<?php namespace spec\Streams\Platform\Addon\Block;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockPresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Block\BlockPresenter');
    }
}