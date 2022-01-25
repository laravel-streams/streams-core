<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\DatetimeValue;

class DatetimeFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_value_to_carbon()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(Carbon::class, $test->datetime);
    }

    public function test_casts_carbon_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->datetime;

        $carbon = new Carbon('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $type->modify($carbon));

        $this->assertSame($carbon->format('Y-m-d H:i:s'), $type->modify($carbon)->format('Y-m-d H:i:s'));    
    }

    public function test_casts_datetime_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->datetime;

        $instance = new \Datetime('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $type->modify($instance));

        $this->assertSame($instance->format('Y-m-d H:i:s'), $type->modify($instance)->format('Y-m-d H:i:s'));    
    }

    public function test_casts_timestamps_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->datetime;

        $timestamp = (new Carbon('2021-01-01 9:30'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $type->modify($timestamp));

        $this->assertSame($timestamp, $type->modify($timestamp)->timestamp);
    }

    public function test_casts_strings_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->datetime;

        $value = '2021-01-01 9:30';
        $standard = '2021-01-01 09:30:00';

        $this->assertInstanceOf(Carbon::class, $type->modify($value));
        
        $this->assertSame($standard, $type->modify($value)->format('Y-m-d H:i:s'));
        $this->assertSame($standard, $type->modify($standard)->format('Y-m-d H:i:s'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(DatetimeValue::class, $test->expand('datetime'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertInstanceOf(Carbon::class, $stream->fields->datetime->generate());
    }
}
