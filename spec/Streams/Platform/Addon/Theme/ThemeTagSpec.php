<?php

namespace spec\Streams\Platform\Addon\Theme;

use Illuminate\Foundation\Application;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ThemeTagSpec extends ObjectBehavior
{
    function let(Application $app)
    {
        $this->beConstructedWith($app);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\Theme\ThemeTag');
    }
}
