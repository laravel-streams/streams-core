<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\IntegerValue;
use Streams\Core\Field\Types\IntegerFieldType;

class IntegerFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_integer()
    {
        $field = new IntegerFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(100, $field->cast(100));
        $this->assertSame(100, $field->cast("100"));

        $this->assertSame(1, $field->cast(1.2));

        $this->assertSame(-2, $field->cast(-2.4));

        $this->assertSame(1234, $field->cast("1,234"));

        $this->assertSame(1234, $field->cast("1,234.50"));

        $this->assertSame(-1234, $field->cast("-1,234.50"));
    }

    public function test_it_returns_integer_value()
    {
        $field = new IntegerFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(IntegerValue::class, $field->decorate(2));
    }
}
