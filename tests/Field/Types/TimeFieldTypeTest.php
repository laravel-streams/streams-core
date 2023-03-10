<?php

namespace Streams\Core\Tests\Field\Types;

use Carbon\Carbon;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Schema\TimeSchema;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\TimeFieldType;
use Streams\Core\Field\Decorator\DatetimeDecorator;

class TimeFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_strings_to_carbon()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = 'Yesterday 9am';

        $this->assertInstanceOf(Carbon::class, $field->cast($value));
        $this->assertInstanceOf(Carbon::class, $field->restore($value));
    }

    public function test_it_stores_time_in_standard_format()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('09:00:00', $field->modify('Yesterday 9am'));
    }

    public function test_it_returns_time_schema()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(TimeSchema::class, $field->schema());
    }

    public function test_it_returns_time_decorator()
    {
        $field = new TimeFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate($field->cast('9am'));

        $this->assertInstanceOf(DatetimeDecorator::class, $decorator);
    }

    public function test_it_generates_time_values()
    {
        $field = new TimeFieldType();

        $this->assertInstanceOf(\Datetime::class, $field->generate());
    }
}
