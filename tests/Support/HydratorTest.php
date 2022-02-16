<?php

namespace Streams\Core\Tests\Support;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Hydrator;

class HydratorTest extends CoreTestCase
{

    public function test_it_extracts_accessible_static_properties()
    {
        $data = Hydrator::dehydrate(new ExampleHydratableObject);

        $this->assertSame([
            'unset_value' => null,
            'public_value' => 'Public Test',
            'protected' => 'Protected Test',
            'boolean' => false,
        ], $data);
    }

    public function test_it_extracts_non_static_properties()
    {
        $object = json_decode(json_encode(['foo' => 'bar']));

        $data = Hydrator::dehydrate($object);

        $this->assertSame(['foo' => 'bar'], $data);
    }

    public function test_it_skips_typed_but_unset_properties()
    {
        $data = Hydrator::dehydrate(new ExampleHydratableObject);

        $this->assertTrue(array_key_exists('unset_value', $data));
    }
}

class ExampleHydratableObject
{
    public string $unsetValue;

    public string $publicValue = 'Public Test';

    protected string $protected = 'Protected Test';

    protected bool $boolean = false;

    private string $private = 'Private Test';

    public function getPrivate()
    {
        return $this->private;
    }

    public function getProtected()
    {
        return $this->protected;
    }

    public function isBoolean()
    {
        return $this->boolean;
    }
}
