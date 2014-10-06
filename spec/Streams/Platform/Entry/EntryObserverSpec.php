<?php namespace spec\Streams\Platform\Entry;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EntryObserverSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Entry\EntryObserver');
    }
}