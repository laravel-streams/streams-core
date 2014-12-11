<?php namespace spec\Anomaly\Streams\Platform;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class StreamsServiceProviderSpec extends LaravelObjectBehavior
{

    function let()
    {
        $this->beConstructedWith(app());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\Streams\Platform\StreamsServiceProvider');
    }
}
