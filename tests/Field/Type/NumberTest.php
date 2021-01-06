<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Support\Facades\Streams;

class NumberTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(100, $test->number);

        $test->number = 1.2;

        $this->assertSame(1.2, $test->number);

        $test->number = -2.4;

        $this->assertSame(-2.4, $test->number);

        $test->number = null;

        $this->assertNull($test->number);

        $test->number = "1,234";

        $this->assertSame(1234, $test->number);

        $test->number = "1,234.50";

        $this->assertSame(1234.5, $test->number);

        $test->number = "-1,234.50";

        $this->assertSame(-1234.5, $test->number);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(NumberValue::class, $test->expand('number'));
    }
}
