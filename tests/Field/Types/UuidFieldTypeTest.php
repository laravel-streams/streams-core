<?php

namespace Streams\Core\Tests\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\StringSchema;
use Streams\Core\Field\Types\UuidFieldType;
use Streams\Core\Field\Decorator\StringDecorator;

class UuidFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_decorator()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertIsString($field->default(true));
    }

    public function test_it_returns_string_decorator()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(
            StringDecorator::class,
            $field->decorate((string) Str::uuid())
        );
    }

    public function test_it_returns_string_schema()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringSchema::class, $field->schema());
    }
}
