<?php

namespace spec\Streams\Platform\Foundation;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApplicationSpec extends ObjectBehavior
{
    function let(Container $app)
    {
        $this->beConstructedWith($app);
    }

    function is_initializes_app_property()
    {
        $this->getApp()->shouldHaveType('Streams\Platform\Foundation\Model\ApplicationModel');
    }
}
