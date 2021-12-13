<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\DateValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Date extends FieldType
{
    public function modify($value)
    {
        return $this->cast($value)->format('Y-m-d');
    }

    public function cast($value): Carbon
    {
        return $this->toCarbon($value)->startOfDay();
    }

    public function expand($value)
    {
        return new DateValue($value);
    }

    public function schema()
    {
        return Schema::string($this->field->handle)->format(Schema::FORMAT_DATE);
    }

    public function generate()
    {
        return $this->cast($this->generator()->date());
    }

    public function toCarbon($value): Carbon
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        if ($value instanceof \Datetime) {
            return Carbon::parse(
                $value->format('Y-m-d H:i:s'),
                $value->getTimezone()
            );
        }

        if (is_string($value) && $this->isStandardDateFormat($value)) {
            return Carbon::instance(Carbon::createFromFormat('Y-m-d', $value)->startOfDay());
        }

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        }

        return Carbon::parse($value);
    }

    protected function isStandardDateFormat($value): bool
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }
}
