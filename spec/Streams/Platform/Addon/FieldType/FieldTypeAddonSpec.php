<?php

namespace spec\Streams\Platform\Addon\FieldType;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldTypeAddonSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypeAddon');
    }

    function it_can_mutate_value()
    {
        $this->mutate('value')->shouldReturn('value');
    }

    function it_can_get_column_type()
    {
        $this->getColumnType()->shouldReturn('string');
    }

    function it_can_set_and_get_column_name()
    {
        $this->setColumnName('foo')->getColumnName()->shouldReturn('foo');
    }

    function it_can_set_and_get_field_name()
    {
        $this->setFieldName('foo')->getFieldName()->shouldReturn('foo');
    }

    function it_can_set_and_get_value()
    {
        $this->setValue('foo')->getValue()->shouldReturn('foo');
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypePresenter');
    }

    function it_can_return_new_service_provider()
    {
        $this->newServiceProvider()->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypeServiceProvider');
    }
}
