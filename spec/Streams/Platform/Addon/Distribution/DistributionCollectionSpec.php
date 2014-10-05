<?php namespace spec\Streams\Platform\Addon\Distribution;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistributionCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Distribution\DistributionCollection');
    }
}