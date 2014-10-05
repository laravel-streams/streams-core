<?php namespace spec\Streams\Platform\Addon\Block;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Block\BlockCollection');
    }
}