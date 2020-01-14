<?php

use Anomaly\Streams\Platform\Support\Hydrator;

class HydratorTest extends TestCase
{

    public function testCanHydrateObject()
    {
        Hydrator::hydrate($object = new HydratorStub(), ['test' => 'foo']);

        $this->assertEquals('foo', $object->getTest());
    }

    public function testCanDehydrateObject()
    {
        $object = (new HydratorStub())->setTest('foo');

        $this->assertEquals(['test' => 'foo'], Hydrator::dehydrate($object));
    }
}

class HydratorStub
{

    protected $test = null;

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }
}
