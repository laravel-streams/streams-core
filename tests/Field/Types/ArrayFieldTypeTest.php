<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\ArrayValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ArrayFieldType;

class ArrayFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_json_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $json = json_encode($array);
        
        $this->assertSame($array, $field->restore($json));
    }

    public function test_it_casts_serialized_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $serialized = serialize($array);
        
        $this->assertSame($array, $field->restore($serialized));
    }

    public function test_it_throws_exception_casting_unknown_strings()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = 'I am not an array.';
        
        $this->assertSame([$value], $field->modify($value));
    }

    public function test_it_returns_array_value()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ArrayValue::class, $field->expand([]));
    }
}
