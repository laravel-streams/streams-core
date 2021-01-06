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
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(100, $test->decimal);

        $test->decimal = 1.2;

        $this->assertSame(1.2, $test->decimal);

        $test->decimal = -2.4;

        $this->assertSame(-2.4, $test->decimal);

        $test->decimal = null;

        $this->assertNull($test->decimal);

        $test->decimal = "1,234";

        $this->assertSame(1234.0, $test->decimal);

        $test->decimal = "1,234.50";

        $this->assertSame(1234.5, $test->decimal);

        $test->decimal = "-1,234.50";

        $this->assertSame(-1234.5, $test->decimal);
    }
}
