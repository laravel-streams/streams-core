<?php namespace spec\Streams\Platform\Addon\Module;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModuleRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Module\ModuleRepository');
    }

    function it_has_its_type_set_to_block()
    {
        $this->getType()->shouldReturn('module');
    }
}