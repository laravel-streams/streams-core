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

    function it_can_return_new_collection()
    {
        $this->newCollection([])->shouldHaveType('Streams\Platform\Addon\AddonCollection');
    }
}
