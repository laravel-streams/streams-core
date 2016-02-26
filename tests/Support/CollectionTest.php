<?php

class CollectionTest extends PHPUnit_Framework_TestCase
{

    public function testShufflePreservesKeys()
    {
        $collection = new \Anomaly\Streams\Platform\Support\Collection(
            [
                'test' => 'Test',
                'foo'  => 'Foo'
            ]
        );

        $this->assertEquals('Test', $collection->shuffle()->get('test'));
    }

    public function testCanPadItems()
    {
        $collection = new \Anomaly\Streams\Platform\Support\Collection(
            [
                'test' => 'Test'
            ]
        );

        $this->assertEquals(3, $collection->pad(3)->count());
    }

    public function testCanPadItemsWithValue()
    {
        $collection = new \Anomaly\Streams\Platform\Support\Collection(
            [
                'test' => 'Test'
            ]
        );

        $this->assertEquals('Foo', $collection->pad(3, 'Foo')->last());
    }
}
