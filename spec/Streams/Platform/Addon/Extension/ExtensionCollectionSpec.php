<?php namespace spec\Streams\Platform\Addon\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Extension\ExtensionCollection');
    }
}