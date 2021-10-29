<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\DateGenerator;

class Date extends Datetime
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return $this->toCarbon($value)->format('Y-m-d');
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return null|Carbon
     */
    public function restore($value)
    {
        if (is_null($value = parent::restore($value))) {
            return $value;
        }

        return $value
            ->setHours(0)
            ->setMinutes(0)
            ->setSeconds(0);
    }

    public function generator(): DateGenerator
    {
        return new DateGenerator($this);
    }
}
