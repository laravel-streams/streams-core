<?php

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
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

        $this->assertTrue(($instance = $collection->instances()) instanceof Collection);
        $this->assertTrue($instance->first() instanceof Addon);
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

        $this->assertTrue(Str::is('*/*-field_type', $collection->type('field_type')->first()['name']));
    }

    public function testEnabled()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->enabled() instanceof AddonCollection);
    }

    public function testInstalled()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->installed() instanceof AddonCollection);
    }

    public function testUninstalled()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->uninstalled() instanceof AddonCollection);
    }

    public function testInstallable()
    {
        $collection = app(AddonCollection::class);

        $this->assertNull($collection->type('field_type')->installable()->first());
        $this->assertNotNull($collection->type('module')->installable()->first());
    }

    public function testCanMapCallToAddonTypeCollection()
    {
        $collection = app(AddonCollection::class);

        $this->assertTrue($collection->fieldTypes() instanceof AddonCollection);
        $this->assertTrue($collection->fieldType() instanceof AddonCollection);

        $this->expectException(\Exception::class);

        $this->assertNull($collection->anything());
    }

    public function testCanMapGetToAddonTypeCollection()
    {
        $collection = app(AddonCollection::class);

        $this->assertNull($collection->something);
        $this->assertTrue($collection->field_types instanceof AddonCollection);
        $this->assertTrue($collection->field_type instanceof AddonCollection);
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
