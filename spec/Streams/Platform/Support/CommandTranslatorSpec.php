<?php

namespace spec\Streams\Platform\Support;

use Streams\Platform\Field\Command\AddFieldCommand;
use Streams\Platform\Spec\TestCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandTranslatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Support\CommandTranslator');
    }

    function it_can_translate_a_command_class_into_its_handler_class()
    {
        $this->toCommandHandler(new TestCommand('Foo'))->shouldReturn('Streams\Platform\Spec\TestCommandHandler');
    }
}
