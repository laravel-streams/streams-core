<?php

namespace spec\Streams\Platform\Addon\Distribution;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistributionAddonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Distribution\DistributionAddon');
    }
}
