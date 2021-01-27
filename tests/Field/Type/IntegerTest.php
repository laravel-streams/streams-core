<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class IntegerTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(100, $test->integer);

        $test->integer = 1.2;

        $this->assertSame(1, $test->integer);

        $test->integer = -2.4;

        $this->assertSame(-2, $test->integer);

        $test->integer = null;

        $this->assertNull($test->integer);

        $test->integer = "1,234";

        $this->assertSame(1234, $test->integer);

        $test->integer = "1,234.50";

        $this->assertSame(1234, $test->integer);

        $test->integer = "-1,234.50";

        $this->assertSame(-1234, $test->integer);
    }
}
