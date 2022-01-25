<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Support\Facades\Streams;

class ArrayFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_array()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertIsArray($test->array);
    }

    public function test_can_cast_json_to_array()
    {
        $type = Streams::make('testing.litmus')->fields->array;

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $json = json_encode($array);
        
        $this->assertSame($array, $type->restore($json));
    }

    public function test_can_cast_serialized_to_array()
    {
        $type = Streams::make('testing.litmus')->fields->array;

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $serialized = serialize($array);
        
        $this->assertSame($array, $type->restore($serialized));
    }

    public function test_can_cast_arrayables_to_array()
    {
        $type = Streams::make('testing.litmus')->fields->array;

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $arrayable = new Entry($array);

        $this->assertSame($array, $type->restore($arrayable));
    }

    public function test_can_cast_generics_to_array()
    {
        $type = Streams::make('testing.litmus')->fields->array;

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $generic = new \stdClass();

        array_walk($array, fn($value, $key) => $generic->$key = $value);

        $this->assertSame($array, $type->modify($generic));
    }

    public function test_throws_exception_casting_unknown_strings()
    {
        $type = Streams::make('testing.litmus')->fields->array;

        $value = 'I am not an array.';
        
        $this->expectException(\Exception::class);

        $type->modify($value);
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(ArrValue::class, $test->expand('array'));
    }

    public function test_can_generate_array()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsArray($stream->fields->array->generate());
    }
}
