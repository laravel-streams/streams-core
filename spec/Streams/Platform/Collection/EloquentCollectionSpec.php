<?php namespace spec\Streams\Platform\Collection;

use Streams\Platform\Stream\StreamModel;
use Streams\Platform\Entry\EntryModel;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EloquentCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $items = [];

        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Collection\EloquentCollection');
    }
}