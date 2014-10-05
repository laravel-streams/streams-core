<?php namespace spec\Streams\Platform\Addon\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtensionPresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Extension\ExtensionPresenter');
    }
}