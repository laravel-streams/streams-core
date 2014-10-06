<?php namespace spec\Streams\Platform\Collection;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CacheCollectionSpec extends ObjectBehavior
{
    function let()
    {
        $items = [
            'foo',
            'bar'
        ];

        $this->beConstructedWith($items, 'key');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Streams\Platform\Collection\CacheCollection');
    }

    function it_can_add_keys()
    {
        $this->addKeys(['baz'])->count()->shouldReturn(3);
    }

    function it_can_index_keys()
    {
        $this->index()->count()->shouldReturn(2);
    }

    function it_can_flush_keys()
    {
        $this->flush()->count()->shouldReturn(0);
    }

    function it_can_set_and_get_key()
    {
        $this->setKey('foo')->getKey()->shouldReturn('foo');
    }

    function it_can_make_keys_unique()
    {
        $this->addKeys(['foo', 'baz'])->count()->shouldReturn(3);
    }
}