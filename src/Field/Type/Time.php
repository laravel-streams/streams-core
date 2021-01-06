<?php

namespace Streams\Core\Field\Type;

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
}
