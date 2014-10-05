<?php namespace spec\Streams\Platform\Addon\Tag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Tag\TagRepository');
    }
}