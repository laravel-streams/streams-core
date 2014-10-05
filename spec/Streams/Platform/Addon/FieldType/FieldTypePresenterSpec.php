<?php namespace spec\Streams\Platform\Addon\FieldType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Streams\Platform\Addon\FieldType\FieldTypeAddon;

class FieldTypePresenterSpec extends ObjectBehavior
{
    function let(FieldTypeAddon $resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypePresenter');
    }

    function it_returns_field_type_value_for_to_string_method()
    {
        $this->__toString()->shouldReturn('');
    }
}