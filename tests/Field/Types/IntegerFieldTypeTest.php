<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\IntegerFieldType;
use Streams\Core\Field\Decorator\NumberDecorator;

class IntegerFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_rules()
    {
        $field = new IntegerFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertContains('numeric', $field->rules());
        $this->assertContains('integer', $field->rules());
    }

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

        $this->assertSame(-1234, $field->default("-1,234.50"));
        $this->assertSame(-1234, $field->restore("-1,234.50"));
    }

    public function test_it_stores_as_an_integer()
    {
        $field = new IntegerFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertSame(100, $field->modify("100"));
    }

    public function test_it_returns_markdown_decorator()
    {
        $field = new IntegerFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(NumberDecorator::class, $field->decorate(2));
    }

    public function test_it_returns_incremental_default_decorator()
    {
        $field = new IntegerFieldType([
            'handle' => 'episode_id',
            'stream' => Streams::make('films'),
        ]);

        $this->assertSame(8, $field->default('increment'));
    }

    public function test_it_generates_integer_values()
    {
        $field = new IntegerFieldType();

        $this->assertIsInt($field->generate());
    }
}
