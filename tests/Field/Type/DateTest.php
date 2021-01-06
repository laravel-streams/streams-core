<?php

namespace Streams\Core\Tests\Field\Type;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class DateTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Carbon::class, $test->date);
        
        $this->assertSame(strtotime('2021-01-01 12:00 am'), $test->date->timestamp);

        $test->date = 'Yesterday 9am';

        $this->assertSame(strtotime('-1 day 12:00 am'), $test->date->timestamp);
    }
}
