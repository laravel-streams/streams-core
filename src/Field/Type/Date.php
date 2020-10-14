<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\DatetimeValue;

/**
 * Class Date
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
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
     * @return string
     */
    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return $this->toCarbon($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new DatetimeValue($value);
    }
}
