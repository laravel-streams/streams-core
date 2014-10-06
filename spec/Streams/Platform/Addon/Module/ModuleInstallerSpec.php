<?php namespace spec\Streams\Platform\Addon\Module;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleInstallerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleInstaller');
    }

    function it_can_set_and_get_installers()
    {
        $this->setInstallers(['foo'])->getInstallers()->shouldReturn(['foo']);
    }
}