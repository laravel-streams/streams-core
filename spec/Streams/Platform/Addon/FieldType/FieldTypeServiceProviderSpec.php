<?php namespace spec\Streams\Platform\Addon\FieldType;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldTypeServiceProviderSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\FieldType\FieldTypeServiceProvider');
    }
}