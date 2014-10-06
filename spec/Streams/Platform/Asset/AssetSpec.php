<?php namespace spec\Streams\Platform\Asset;

use Illuminate\Filesystem\Filesystem;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Streams\Platform\Foundation\Application;

class AssetSpec extends ObjectBehavior
{
    function let(Filesystem $files, Application $application)
    {
        $this->beConstructedWith($files, $application);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Asset\Asset');
    }

    function it_can_add_and_get_namespace()
    {
        $this->addNamespace('foo', 'bar/baz')->getNamespace('foo')->shouldReturn('bar/baz');
    }

    function it_can_set_and_get_filters()
    {
        $this->setFilters('foo', ['bar'])->getFilters('foo')->shouldReturn(['bar']);
    }

    function it_can_return_null_filters_if_collection_does_not_exist()
    {
        $this->setFilters('foo', ['bar'])->getFilters('baz')->shouldReturn(null);
    }
}