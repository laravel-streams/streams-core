<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\DatetimeValue;
use Streams\Core\Field\Types\DatetimeFieldType;

class DatetimeFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_carbon_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $carbon = new Carbon('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $field->cast($carbon));
    }

    public function test_it_casts_datetime_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $instance = new \Datetime('2021-01-01 09:30:00');

        $this->assertInstanceOf(Carbon::class, $field->cast($instance));
    }

    public function test_it_casts_timestamps_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01 9:30'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->cast($timestamp));
    }

    public function test_it_casts_strings_to_carbon()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = '2021-01-01 9:30';

        $this->assertInstanceOf(Carbon::class, $field->cast($value));
    }

    public function test_it_returns_datetime_value()
    {
        $field = new DatetimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DatetimeValue::class, $field->expand('2021-01-01 9:30'));
    }
}
