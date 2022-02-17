<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\StringValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\StringFieldType;

class StringFieldTypeTest extends CoreTestCase
{
    public function test_casts_to_string()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('100', $field->cast(100));
    }

    public function test_it_returns_string_value()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringValue::class, $field->expand('example'));
    }
}
