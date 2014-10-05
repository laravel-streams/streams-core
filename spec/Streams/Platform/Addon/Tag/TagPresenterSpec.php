<?php namespace spec\Streams\Platform\Addon\Tag;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagPresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Tag\TagPresenter');
    }
}