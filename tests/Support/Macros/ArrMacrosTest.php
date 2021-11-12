<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;

class ArrMacrosTest extends TestCase
{

    public function test_can_make_arrays_from_basic_objects()
    {
        $object = json_decode(json_encode(['foo' => 'bar']));

        $array = Arr::make($object);

        $this->assertSame(['foo' => 'bar'], $array);
    }

    public function test_can_make_arrays_from_array_accessible_objects()
    {
        $object = new Entry(['foo' => 'bar']);

        $array = Arr::make($object);

        $this->assertSame(['foo' => 'bar'], $array);
    }

    public function test_can_make_arrays_recursively()
    {
        $object = new Entry(['foo' => 'bar']);

        $array = Arr::make(['test' => $object]);

        $this->assertSame(['test' => ['foo' => 'bar']], $array);
    }

    public function test_can_make_arrays_from_interpretable_objects()
    {
        $object = new ExampleArrayInterpretableObject;

        $array = Arr::make($object);

        $this->assertSame([
            'public_value' => 'Public Test',
            'protected' => 'Protected Test',
            'boolean' => false,
        ], $array);
    }

    public function test_can_undot_dotted_arrays()
    {
        $dotted = [
            'foo.bar' => 'baz',
        ];

        $array = Arr::undot($dotted);

        $this->assertSame([
            'foo' => [
                'bar' => 'baz',
            ]
        ], $array);
    }

    public function test_can_export_arrays()
    {
        $export = Arr::export(['foo' => 'bar']);

        $this->assertSame("[\n    'foo' => 'bar',\n]", $export);
    }

    public function test_can_parse_array_values()
    {
        $array = Arr::parse(['path' => '{request.url}']);

        $this->assertSame(['path' => env('APP_URL')], $array);
    }
}

class ExampleArrayInterpretableObject
{
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
