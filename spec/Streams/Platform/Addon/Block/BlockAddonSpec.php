<?php

namespace spec\Streams\Platform\Addon\Block;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BlockAddonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Block\BlockAddon');
    }
}
