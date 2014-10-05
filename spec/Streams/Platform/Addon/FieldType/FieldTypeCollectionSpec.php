<?php namespace spec\Streams\Platform\Addon\FieldType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldTypeCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypeCollection');
    }
}