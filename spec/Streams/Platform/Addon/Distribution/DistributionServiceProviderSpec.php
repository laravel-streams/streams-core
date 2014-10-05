<?php namespace spec\Streams\Platform\Addon\Distribution;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistributionServiceProviderSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Distribution\DistributionServiceProvider');
    }
}