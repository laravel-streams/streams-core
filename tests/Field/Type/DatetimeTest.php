<?php

namespace Streams\Core\Tests\Field\Type;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\DatetimeValue;

class DatetimeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Carbon::class, $test->datetime);
        
        $this->assertSame(strtotime('2021-01-01 9:30'), $test->datetime->timestamp);

        $test->datetime = 'Yesterday 9am';

        $this->assertSame(strtotime('-1 day 9:00 am'), $test->datetime->timestamp);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(DatetimeValue::class, $test->expand('datetime'));
    }
}
