<?php namespace spec\Streams\Platform\Entry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntryCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $items = [];

        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Entry\EntryCollection');
    }
}