<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class TimeFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function test_casts_value_to_carbon()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Carbon::class, $test->time);
    }
    
    public function test_casts_strings_to_carbon()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame(strtotime('9:30 am'), $test->time->timestamp);

        $test->time = 'Yesterday 9am';

        $this->assertSame('9:00 am', $test->time->format('g:i a'));
    }

    public function test_stores_time_as_standard_format()
    {
        $type = Streams::make('testing.litmus')->fields->time;

        $this->assertSame('09:00:00', $type->modify('Yesterday 9am'));
    }

    public function test_can_generate_time()
    {
        $type = Streams::make('testing.litmus')->fields->time;

        $time = $type->generate();

        $this->assertSame($time, $type->restore($time)->format('H:i:s'));
    }
}
