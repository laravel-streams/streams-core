<?php namespace spec\Streams\Platform\Addon\Module;

use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;
use Streams\Platform\Foundation\Application;
use Streams\Platform\Foundation\ApplicationModel;

class ModuleModelSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleModel');
    }

    /*function it_can_mark_a_module_as_installed_by_slug()
    {
        $this->installed('addons')->shouldReturn('Streams\Platform\Addon\Module\ModuleModel');
    }*/
}