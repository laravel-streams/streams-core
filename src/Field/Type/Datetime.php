<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\Date;
use Streams\Core\Field\Value\DatetimeValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Datetime extends FieldType
{
    public function modify($value)
    {
        return $this->cast($value)->format('Y-m-d H:i:s');
    }

    public function cast($value): Carbon
    {
        return $this->toCarbon($value);
    }

    public function expand($value)
    {
        return new DatetimeValue($value);
    }

    public function schema()
    {
        return Schema::string($this->field->handle)->format(Schema::FORMAT_DATE_TIME);
    }

    public function generate()
    {
        return $this->cast($this->generator()->dateTime());
    }

    public function toCarbon($value): Carbon
    {
        if ($value instanceof Carbon) {
            return Date::instance($value);
        }

        if ($value instanceof \Datetime) {
            return Date::parse(
                $value->format('Y-m-d H:i:s'),
                $value->getTimezone()
            );
        }

        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        }

        return Date::parse($value);
    }
}
