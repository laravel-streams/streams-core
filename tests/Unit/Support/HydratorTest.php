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
        $object = (new HydratorStub())
            ->setTest('foo');

        $this->assertEquals([
            'test' => 'foo',
            'boolean' => true
        ], Hydrator::dehydrate($object));
    }
}

class HydratorStub
{

    protected $test = null;

    protected $boolean = true;

    protected $notMapped = true;

    public function getTest()
    {
        return $this->test;
    }

    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    public function isBoolean()
    {
        return $this->boolean;
    }
}
