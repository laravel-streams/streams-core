<?php

namespace spec\Anomaly\Streams\Platform\Support;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EvaluatorSpec extends ObjectBehavior
{

    function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\Streams\Platform\Support\Evaluator');
    }

    function it_can_safely_evaluate_non_applicable_strings()
    {
        $target = 'foo';

        return $this->evaluate($target)->shouldReturn('foo');
    }

    function it_can_evaluate_closures()
    {
        $target = function(){
            return 'foo';
        };

        $this->evaluate($target)->shouldReturn(null);
    }

    function it_can_evaluate_arrays()
    {
        $target = ['foo' => ['bar']];

        $this->evaluate($target)->shouldReturn($target);
    }
}
