<?php namespace spec\Streams\Platform\Addon\Tag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Tag\TagCollection');
    }
}