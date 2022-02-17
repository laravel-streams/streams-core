<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;

class ArrMakeTest extends CoreTestCase
{
    public function test_it_supports_generic_objects()
    {
        $object = json_decode(json_encode(['foo' => 'bar']));

        $array = Arr::make($object);

        $this->assertSame(['foo' => 'bar'], $array);
    }

    // public function test_it_supports_array_accessible_objects()
    // {
    //     $object = new Entry(['foo' => 'bar']);

    //     $array = Arr::make($object);

    //     $this->assertSame(['foo' => 'bar'], $array);
    // }

    public function test_it_make_arrays_recursively()
    {
        $object = new Entry(['foo' => 'bar']);

        $array = Arr::make(['test' => $object]);

        $this->assertSame(['test' => ['foo' => 'bar']], $array);
    }

    public function test_it_supports_interpretable_objects()
    {
        $object = new ExampleArrayInterpretableObject;

        $array = Arr::make($object);

        $this->assertSame([
            'unset_typed_value' => null,
            'public_value' => 'Public Test',
            'protected' => 'Protected Test',
            'boolean' => false,
        ], $array);
    }
}

class ExampleArrayInterpretableObject
{
    public string $unsetTypedValue;

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
