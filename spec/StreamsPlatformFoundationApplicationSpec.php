<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StreamsPlatformFoundationApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('StreamsPlatformFoundationApplication');
    }
}
