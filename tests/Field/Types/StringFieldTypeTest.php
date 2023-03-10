<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\StringSchema;
use Streams\Core\Field\Types\StringFieldType;
use Streams\Core\Field\Decorator\StringDecorator;

class StringFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_string()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('100', $field->modify(100));
        $this->assertSame('100', $field->restore(100));
    }

    public function test_it_converts_structures_to_json()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $object = json_decode($json = json_encode(['foo' => 'bar']));

        $this->assertSame($json, $field->cast($object));
    }

    public function test_it_returns_string_decorator()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringDecorator::class, $field->decorate('example'));
    }

    public function test_it_returns_string_schema()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringSchema::class, $field->schema());
    }

    public function test_it_generates_string_values()
    {
        $field = new StringFieldType();

        $this->assertIsString($field->generate());
    }
}
