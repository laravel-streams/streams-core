<?php

use Anomaly\Streams\Platform\Collection\CacheCollection;

class CacheCollectionTest extends \PHPUnit_Framework_TestCase
{
    protected function stub()
    {
        return new CacheCollection(['foo', 'bar'], 'foo.bar');
    }

    public function testItCanAddKeys()
    {
        $collection = $this->stub();

        $collection->addKeys(['baz']);

        $this->assertEquals(3, $collection->count());
    }

    public function testItCanIndexCache()
    {
        $collection = $this->stub();

        $collection->index();

        $expected = ['foo', 'bar'];
        $actual   = app('cache')->get('foo.bar');

        $this->assertEquals($expected, $actual);
    }

    public function testItCanFlushItself()
    {
        $collection = $this->stub();

        $collection->index();
        $collection->flush();

        $expected = null;
        $actual   = app('cache')->get('foo.bar');

        $this->assertEquals($expected, $actual);
    }

    public function testItMaintainsUniqueItems()
    {
        $collection = $this->stub();

        $collection->addKeys(['bar', 'baz']);

        $expected = ['foo', 'bar', 'baz'];
        $actual   = $collection->all();

        $this->assertEquals($expected, $actual);
    }

    public function testItCanSetAndGetKey()
    {
        $collection = $this->stub();

        $this->assertEquals('bar.baz', $collection->setKey('bar.baz')->getKey());
    }
}
 