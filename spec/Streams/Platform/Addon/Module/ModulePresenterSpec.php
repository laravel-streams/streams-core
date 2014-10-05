<?php namespace spec\Streams\Platform\Addon\Module;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModulePresenterSpec extends ObjectBehavior
{
    function let($resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModulePresenter');
    }
}