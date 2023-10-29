<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\DateFieldType;
use Streams\Core\Field\Decorator\DatetimeDecorator;

class DateFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_carbon_values()
    {
        $entry = Streams::repository('films')->find(4);

        $this->assertInstanceOf(Carbon::class, $entry->created);

        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->restore($timestamp));
    }

    public function test_it_casts_carbon_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $carbon = new Carbon('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $field->cast($carbon));
    }

    public function test_it_casts_datetime_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $instance = new \Datetime('2021-01-01');

        $this->assertInstanceOf(Carbon::class, $field->cast($instance));
    }

    public function test_it_casts_timestamps_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $timestamp = (new Carbon('2021-01-01'))->timestamp;

        $this->assertInstanceOf(Carbon::class, $field->cast($timestamp));
    }

    public function test_it_casts_strings_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(Carbon::class, $field->cast('2021-01-01'));
        $this->assertInstanceOf(Carbon::class, $field->cast('yesterday'));
    }

    public function test_it_stores_as_date_string()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $date = '2021-01-01';

        $this->assertSame($date, $field->modify(new Carbon($date)));
    }

    public function test_it_restores_as_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $date = '2021-01-01';

        $this->assertInstanceOf(Carbon::class, $field->restore($date));
    }

    public function test_it_casts_default_value_to_carbon()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(Carbon::class, $field->default('now'));
    }

    public function test_it_returns_date_decorator()
    {
        $field = new DateFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(DatetimeDecorator::class, $field->decorate('2021-01-01'));
    }

    public function test_it_generates_date_values()
    {
        $field = new DateFieldType();

        $this->assertInstanceOf(Carbon::class, $field->generate());

        $field = new DateFieldType([
            'rules' => [
                'min:2021-01-01',
                'max:2021-01-02',
            ],
        ]);

        $this->assertTrue($field->generate()->between('2021-01-01', '2021-01-02'));
    }
}
