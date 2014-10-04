<?php

namespace spec\Streams\Platform\Addon;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddonRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\AddonRepository');
    }
}
