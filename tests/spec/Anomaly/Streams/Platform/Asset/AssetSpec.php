<?php

namespace spec\Anomaly\Streams\Platform\Asset;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AssetSpec extends ObjectBehavior
{

    function let()
    {
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\Streams\Platform\Asset\Asset');
    }

    function it_adds_asset_to_group()
    {
        $this
            ->add('foo.css', 'bar.css', ['min'])
            ->shouldHaveType('Anomaly\Streams\Platform\Asset\Asset');
    }

    function it_converts_path_to_publishable_path()
    {
        $this
            ->path('foo.css')
            ->shouldReturn('assets/default/0e0fe80c006c9e57289549b9298365a6.css');
    }
}
