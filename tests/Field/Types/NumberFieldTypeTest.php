<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\NumberFieldType;
use Streams\Core\Field\Decorator\NumberDecorator;

class NumberFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_rule()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertContains('numeric', $field->rules());
    }

    public function test_it_casts_default_values()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);
        
        $this->assertSame(-1234.50, $field->default("-1,234.50"));
    }

    public function test_it_casts_to_numeric_decorator()
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

    public function test_it_stores_as_number()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(-1234.50, $field->modify("-1,234.50"));
    }

    public function test_it_restores_as_number()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(-1234.50, $field->restore("-1,234.50"));
    }

    public function test_it_returns_number_decorator()
    {
        $field = new NumberFieldType([
            'stream' => Streams::make('films')
        ]);
        
        $this->assertInstanceOf(NumberDecorator::class, $field->decorate(100));
    }
}
