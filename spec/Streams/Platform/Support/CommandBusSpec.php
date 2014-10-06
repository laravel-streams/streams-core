<?php namespace spec\Streams\Platform\Support;

use Streams\Platform\Support\CommandTranslator;
use Illuminate\Foundation\Application;
use Streams\Platform\Spec\Command;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandBusSpec extends ObjectBehavior
{
    function let(Application $app, CommandTranslator $commandTranslator)
    {
        $this->beConstructedWith($app, $commandTranslator);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Support\CommandBus');
    }

    /*function it_can_execute_a_command()
    {
        $this->execute(new TestCommand('foo'))->shouldReturn('foo');
    }*/
}