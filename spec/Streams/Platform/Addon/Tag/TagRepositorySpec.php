<?php namespace spec\Streams\Platform\Addon\Tag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Tag\TagRepository');
    }

    function it_has_its_type_set_to_block()
    {
        $this->getType()->shouldReturn('tag');
    }
}