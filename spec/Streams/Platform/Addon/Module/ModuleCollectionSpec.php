<?php namespace spec\Streams\Platform\Addon\Module;

use Streams\Platform\Addon\Module\ModuleAddon;
use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleCollectionSpec extends ObjectBehavior
{
    function let($items = [])
    {
        $items = [
            new ModuleAddon(new Application()),
            (new ModuleAddon(new Application()))->setInstalled(true)->setEnabled(true)
        ];

        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleCollection');
    }

    function it_can_return_collection_of_installed_modules()
    {
        $this->installed()->shouldHaveType('Streams\Platform\Addon\Module\ModuleCollection');
    }

    function it_can_return_collection_of_enabled_modules()
    {
        $this->enabled()->shouldHaveType('Streams\Platform\Addon\Module\ModuleCollection');
    }
}