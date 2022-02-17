<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Field\Types\NumberFieldType;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Facades\Streams;

class NumberFieldTypeTest extends CoreTestCase
{

    public function test_it_casts_to_numeric_value()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(100, $field->cast(100));
        
        $this->assertSame(100, $field->cast("100"));

        $this->assertSame(1.2, $field->cast(1.2));

        $this->assertSame(-2.4, $field->cast(-2.4));

        $this->assertSame(1234, $field->cast("1,234"));

        $this->assertSame(1234.50, $field->cast("1,234.50"));

        $this->assertSame(-1234.50, $field->cast("-1,234.50"));
    }

    public function test_expanded_value()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);
        
        $this->assertInstanceOf(NumberValue::class, $field->expand(100));
    }
}
