<?php namespace spec\Streams\Platform\Spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BootstrapSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Spec\Bootstrap');
    }
}