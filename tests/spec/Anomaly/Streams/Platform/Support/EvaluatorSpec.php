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
    /*function it_can_evaluate_array_data_in_a_string()
    {
        $data = ['foo' => 'bar'];

        return $this->evaluate('{{ data.foo }}', compact('data'))->shouldReturn('barssdf');
    }*/
}
