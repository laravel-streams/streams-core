<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Support\Collection;

class CollectionTest extends TestCase
{

    public function testCanMapGetToCall()
    {
        $collection = new CollectionStub(
            [
                'foo' => 'bar'
            ]
        );

        $this->assertEquals('bar', $collection->foo);
        $this->assertEquals('baz', $collection->foo_bar);
    }
}

class CollectionStub extends Collection
{

    public function fooBar()
    {
        return 'baz';
    }
}
