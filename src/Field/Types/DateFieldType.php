<?php

namespace Streams\Core\Field\Types;

use Carbon\Carbon;
use Streams\Core\Field\Schema\DateSchema;
use Streams\Core\Field\Presenter\DatePresenter;

class DateFieldType extends DatetimeFieldType
{
    public function cast($value): Carbon
    {
        return $this->toCarbon($value)->startOfDay();
    }
    
    public function modify($value)
    {
        return $this->cast($value)->format('Y-m-d');
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function getPresenterName()
    {
        return DatePresenter::class;
    }

    public function getSchemaName()
    {
        return DateSchema::class;
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
