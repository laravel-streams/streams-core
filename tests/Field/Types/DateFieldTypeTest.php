<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\DatetimeValue;
use Streams\Core\Field\Value\DateValue;

class DateFieldTypeTest extends TestCase
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

        $this->assertInstanceOf(Carbon::class, $test->date);
    }

    public function test_casts_carbon_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->date;

        $carbon = new Carbon('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $type->modify($carbon));

        $this->assertSame($carbon->format('Y-m-d'), $type->modify($carbon)->format('Y-m-d'));
    }

    public function test_casts_datetime_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->date;

        $instance = new \Datetime('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $type->modify($instance));

        $this->assertSame($instance->format('Y-m-d'), $type->modify($instance)->format('Y-m-d'));
    }

    public function test_casts_timestamps_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->date;

        $timestamp = (new Carbon('2021-01-01'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $type->modify($timestamp));

        $this->assertSame($timestamp, $type->modify($timestamp)->timestamp);
    }

    public function test_casts_strings_to_carbon()
    {
        $type = Streams::make('testing.litmus')->fields->date;

        $date = '2021-01-01';
        $value = '2021-01-01 9:30';
        $standard = '2021-01-01 09:30:00';

        $this->assertInstanceOf(Carbon::class, $type->modify($value));

        $this->assertSame($date, $type->modify($date)->format('Y-m-d'));
        $this->assertSame($date, $type->modify($value)->format('Y-m-d'));
        $this->assertSame($date, $type->modify($standard)->format('Y-m-d'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(DateValue::class, $test->expand('date'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->date->generate();

        $this->assertInstanceOf(\DateTime::class, $fake);
    }
}
