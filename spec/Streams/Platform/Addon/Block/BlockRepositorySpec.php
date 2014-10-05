<?php namespace spec\Streams\Platform\Addon\Block;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Block\BlockRepository');
    }

    function it_has_its_type_set_to_block()
    {
        $this->getType()->shouldReturn('block');
    }
}