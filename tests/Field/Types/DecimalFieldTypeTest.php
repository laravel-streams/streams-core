<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\DecimalValue;
use Streams\Core\Field\Types\DecimalFieldType;

class DecimalFieldTypeTest extends CoreTestCase
{
    public function test_casts_to_decimal()
    {
        $field = new DecimalFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(100.0, $field->cast("100"));

        $this->assertSame(1.2, $field->cast(1.2));

        $this->assertSame(-2.4, $field->cast(-2.4));

        $this->assertSame(1234.0, $field->cast("1,234"));

        $this->assertSame(1234.5, $field->cast("1,234.50"));

        $this->assertSame(-1234.5, $field->cast("-1,234.50"));
    }

    public function test_expanded_value()
    {
        $field = new DecimalFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DecimalValue::class, $field->expand(1.2));
    }
}
