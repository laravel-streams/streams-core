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

    public function generator(): TimeGenerator
    {
        return new TimeGenerator($this);
    }
}
