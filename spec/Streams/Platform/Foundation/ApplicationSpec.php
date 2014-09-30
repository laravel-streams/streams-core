<?php

namespace spec\Streams\Platform\Foundation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Foundation\Application');
    }
}
