<?php

namespace spec\Streams\Platform\Addon\Tag;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TagAddonSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Tag\TagAddon');
    }

    function it_should_return_correct_type()
    {
        $this->getType()->shouldReturn('tag');
    }

    function it_can_parse_a_string_into_an_array()
    {
        $this->parseIntoArray('foo=bar|baz=foo')->shouldReturn(['foo' => 'bar', 'baz' => 'foo']);
    }

    function it_can_set_and_get_attributes()
    {
        $this->setAttributes(['foo' => 'bar'])->getAttributes()->shouldReturn(['foo' => 'bar']);
    }

    function it_can_set_and_get_content()
    {
        $this->setContent('foo')->getContent()->shouldReturn('foo');
    }

    function it_can_set_and_get_plugin_name()
    {
        $this->setPluginName('foo')->getPluginName()->shouldReturn('foo');
    }

    function it_can_get_an_attribute()
    {
        $this->setAttributes(['foo' => 'bar', 'baz' => 'foo']);
        $this->getAttribute('baz')->shouldReturn('foo');
    }

    function it_can_get_an_attribute_as_an_array()
    {
        $this->setAttributes(['foo' => 'bar', 'baz' => 'foo=too']);
        $this->getAttributeAsArray('baz')->shouldReturn(['foo' => 'too']);
    }

    function it_can_get_an_attribute_as_a_boolean()
    {
        $this->setAttributes(['foo' => 'bar', 'baz' => 'yes']);
        $this->getAttributeAsBoolean('baz')->shouldReturn(true);
    }

    function it_can_return_new_presenter()
    {
        $this->newPresenter()->shouldHaveType('Streams\Platform\Addon\Tag\TagPresenter');
    }

    function it_can_return_new_service_provider()
    {
        $this->newServiceProvider()->shouldHaveType('Streams\Platform\Addon\Tag\TagServiceProvider');
    }
}
