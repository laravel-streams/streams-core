<?php

namespace Streams\Core\Tests\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\StringValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\UuidFieldType;

class UuidFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_value()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertIsString($field->default(true));
    }

    public function test_it_returns_string_value()
    {
        $field = new UuidFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(
            StringValue::class,
            $field->expand((string) Str::uuid())
        );
    }
}
