<?php

namespace spec\Anomaly\Streams\Platform\Support;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResolverSpec extends ObjectBehavior
{

    function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\Streams\Platform\Support\Resolver');
    }

    function it_can_resolve_handlers()
    {
        $target = 'Anomaly\Streams\Platform\Support\stub\Handler@handle';

        $this->resolve($target)->shouldReturn(null);
    }

    function it_will_return_non_handlers_unmodified()
    {
        $target = 'foo';

        $this->resolve($target)->shouldReturn('foo');
    }
}
