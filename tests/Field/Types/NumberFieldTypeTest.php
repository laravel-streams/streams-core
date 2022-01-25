<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Facades\Streams;

class NumberFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_numeric_value()
    {
        $type = Streams::make('testing.litmus')->fields->number;

        $this->assertSame(100, $type->modify("100"));
        $this->assertSame(100, $type->restore("100"));

        $this->assertSame(1.2, $type->modify(1.2));
        $this->assertSame(1.2, $type->restore(1.2));

        $this->assertSame(-2.4, $type->modify(-2.4));
        $this->assertSame(-2.4, $type->restore(-2.4));

        $this->assertSame(1234, $type->modify("1,234"));
        $this->assertSame(1234, $type->restore("1,234"));

        $this->assertSame(1234.50, $type->modify("1,234.50"));
        $this->assertSame(1234.50, $type->restore("1,234.50"));

        $this->assertSame(-1234.50, $type->modify("-1,234.50"));
        $this->assertSame(-1234.50, $type->restore("-1,234.50"));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(NumberValue::class, $test->expand('number'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsNumeric($stream->fields->number->generate());
    }
}
