<?php

namespace Streams\Core\Tests\Field\Type;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class TimeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
dd($test->time);
        $this->assertInstanceOf(Carbon::class, $test->getPrototypeAttribute('time'));
        
        // $this->assertSame(strtotime('9:30 am'), $test->time->timestamp);

        // $test->time = 'Yesterday 9am';

        // $this->assertSame(strtotime('Today 9:00 am'), $test->time->timestamp);
    }
}
