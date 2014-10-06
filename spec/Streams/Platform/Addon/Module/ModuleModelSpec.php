<?php namespace spec\Streams\Platform\Addon\Module;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleModelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleModel');
    }

    /*function it_can_mark_a_module_as_installed_by_slug()
    {
        $this->installed('module')->shouldReturn('Streams\Platform\Addon\Module\ModuleModel');
    }*/
}