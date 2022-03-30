<?php

namespace Streams\Core\Field\Types;

use Carbon\Carbon;

class TimeFieldType extends DatetimeFieldType
{
    public function modify($value): string
    {
        return $this->cast($value)->format('H:i:s');
    }

    public function restore($value): Carbon
    {
        return $this->cast($value);
    }

    // public function getSchemaName()
    // {
    //     return TimeSchema::class;
    // }

    // public function generate()
    // {
    //     return $this->generator()->time();
    // }
}
