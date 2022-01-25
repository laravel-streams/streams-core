<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Field\Value\DecimalValue;
use Tests\TestCase;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Facades\Streams;

class DecimalFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_decimal()
    {
        $type = Streams::make('testing.litmus')->fields->decimal;

        $this->assertSame(100.0, $type->modify("100"));

        $this->assertSame(1.2, $type->modify(1.2));

        $this->assertSame(-2.4, $type->modify(-2.4));

        $this->assertSame(1234.0, $type->modify("1,234"));

        $this->assertSame(1234.5, $type->modify("1,234.50"));

        $this->assertSame(-1234.5, $type->modify("-1,234.50"));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(DecimalValue::class, $test->expand('decimal'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->decimal->generate();

        $this->assertIsNumeric($fake);

        $fake = (string) $fake;
        $fake = explode('.', $fake);

        $decimals = array_unshift($fake);
        
        $this->assertTrue(strlen($decimals) === 1);
    }
}
