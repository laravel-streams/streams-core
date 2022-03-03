<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ArrayFieldType;
use Streams\Core\Field\Decorator\ArrayDecorator;

class ArrayFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_json_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $json = json_encode($array);

        $this->assertSame($array, $field->cast($json));
    }

    public function test_it_casts_serialized_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $array = ['foo' => 'Foo', 'bar' => 'Bar'];

        $serialized = serialize($array);

        $this->assertSame($array, $field->cast($serialized));
    }

    public function test_it_casts_arbitrary_string_to_array()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = 'I am not an array.';

        $this->assertSame([$value], $field->cast($value));
    }

    public function test_it_casts_when_modifying()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([0 => 'yes'], $field->modify('yes'));
    }

    public function test_it_casts_when_restoring()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([0 => 'yes'], $field->restore('yes'));
    }

    public function test_it_returns_array_decorator()
    {
        $field = new ArrayFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ArrayDecorator::class, $field->decorate($field, []));
    }
}
