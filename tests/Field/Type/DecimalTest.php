<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Facades\Streams;

class DecimalTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->decimal->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToDecimal()
    {
        $type = Streams::make('testing.litmus')->fields->decimal->type();

        $this->assertSame(100.0, $type->modify("100"));
        $this->assertSame(100.0, $type->restore("100"));

        $this->assertSame(1.2, $type->modify(1.2));
        $this->assertSame(1.2, $type->restore(1.2));

        $this->assertSame(-2.4, $type->modify(-2.4));
        $this->assertSame(-2.4, $type->restore(-2.4));

        $this->assertSame(1234.0, $type->modify("1,234"));
        $this->assertSame(1234.0, $type->restore("1,234"));

        $this->assertSame(1234.5, $type->modify("1,234.50"));
        $this->assertSame(1234.5, $type->restore("1,234.50"));

        $this->assertSame(-1234.5, $type->modify("-1,234.50"));
        $this->assertSame(-1234.5, $type->restore("-1,234.50"));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(NumberValue::class, $test->expand('decimal'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->decimal->type()->generate();

        $this->assertIsNumeric($fake);

        $fake = (string) $fake;
        $fake = explode('.', $fake);

        $decimals = array_unshift($fake);
        
        $this->assertTrue(strlen($decimals) === 1);
    }
}
