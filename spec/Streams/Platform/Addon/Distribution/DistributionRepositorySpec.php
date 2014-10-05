<?php namespace spec\Streams\Platform\Addon\Distribution;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistributionRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Distribution\DistributionRepository');
    }

    function it_has_its_type_set_to_block()
    {
        $this->getType()->shouldReturn('distribution');
    }
}