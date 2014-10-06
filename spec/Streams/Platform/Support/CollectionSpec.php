<?php

namespace spec\Streams\Platform\Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CollectionSpec extends ObjectBehavior
{
    function let()
    {
        $items = [
            'foo',
            'bar'
        ];

        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Support\Collection');
    }
}
