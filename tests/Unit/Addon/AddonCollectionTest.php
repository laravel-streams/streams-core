<?php

use Tests\TestCase;
use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;

class AddonCollectionTest extends TestCase
{

    public function testNamespaces()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue(in_array('anomaly.module.users::foo', $collection->namespaces('foo')));
    }

    public function testCore()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->core()->has('anomaly.module.users'));
    }

    public function testNonCore()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue(!$collection->nonCore()->has('anomaly.module.users'));
    }

    public function testInstances()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->instances()->first() instanceof Addon);
    }

    public function testInstance()
    {
        $collection = app(AddonCollection::class);

        $this->assertNull($collection->instance('anomaly.module.foo'));
        $this->assertTrue($collection->instance('anomaly.module.users') instanceof Addon);
    }

    public function testType()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue(str_is('*/*-field_type', $collection->type('field_type')->first()['name']));
    }

    /**
     * Functional
     */
    public function testKeysByNamespace()
    {
        $collection = app(AddonCollection::class);

        $this->assertNotNull($collection->all()['anomaly.module.users']);
    }
}
