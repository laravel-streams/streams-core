<?php namespace spec\Streams\Platform\Addon\FieldType;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldTypeRepositorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypeRepository');
    }
}