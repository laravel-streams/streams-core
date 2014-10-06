<?php namespace spec\Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use Streams\Platform\Addon\Addon;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddonCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $items = [
            new Addon(new Application()),
            new Addon(new Application())
        ];

        $this->beConstructedWith($items);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Addon\AddonCollection');
    }

    function it_can_find_an_addon_by_its_slug()
    {
        $this->findBySlug('foo')->shouldReturn(null);
    }

    function it_returns_an_addon_class_when_slug_is_matched()
    {
        $this->findBySlug('abstract')->shouldHaveType('Streams\Platform\Addon\Addon');
    }
}