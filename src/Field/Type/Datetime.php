<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\Date;
use Streams\Core\Field\Value\DatetimeValue;

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
