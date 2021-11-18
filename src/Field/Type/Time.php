<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\TimeGenerator;

class Time extends Datetime
{
    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return $this->toCarbon($value)->format('H:i:s');
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return $this->toCarbon($value);
    }

    public function generate()
    {
        return $this->generator()->time();
    }
}
