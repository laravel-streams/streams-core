<?php namespace spec\Streams\Platform\Addon\Distribution;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DistributionPresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Distribution\DistributionPresenter');
    }
}