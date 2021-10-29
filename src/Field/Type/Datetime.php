<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use DateTimeInterface;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use Streams\Core\Field\Value\DatetimeValue;
use Streams\Core\Field\Factory\DatetimeGenerator;

class Datetime extends Str
{
    public function modify($value)
    {
        return $this->toCarbon($value)->format('Y-m-d H:i:s');
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return $this->toCarbon($value);
    }

    public function expand($value)
    {
        return new DatetimeValue($value);
    }

    public function generator(): DatetimeGenerator
    {
        return new DatetimeGenerator($this);
    }

    /**
     * Convert the value to a Carbon instance.
     *
     * @param mixed $value
     * @return Carbon
     */
    public function toCarbon($value)
    {
        // If this value is already a Carbon instance, we shall just return it as is.
        // This prevents us having to re-instantiate a Carbon instance when we know
        // it already is one, which wouldn't be fulfilled by the DateTime check.
        if ($value instanceof CarbonInterface) {
            return Date::instance($value);
        }

        // If the value is already a DateTime instance, we will just skip the rest of
        // these checks since they will be a waste of time, and hinder performance
        // when checking the field. We will just return the DateTime right away.
        if ($value instanceof DateTimeInterface) {
            return Date::parse(
                $value->format('Y-m-d H:i:s.u'),
                $value->getTimezone()
            );
        }

        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        if ($this->isStandardDateFormat($value)) {
            return Date::instance(Carbon::createFromFormat('Y-m-d', $value)->startOfDay());
        }

        $format = 'Y-m-d H:i:s'; //$this->getDateFormat();

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        if (Date::hasFormat($value, $format)) {
            return Date::createFromFormat($format, $value);
        }

        return Date::parse($value);
    }

    /**
     * Determine if the given value is a standard date format.
     *
     * @param string $value
     * @return bool
     */
    protected function isStandardDateFormat($value)
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }
}
