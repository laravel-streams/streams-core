<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;

class Time extends Datetime
{
    public function modify($value): string
    {
        return $this->toCarbon($value)->format('H:i:s');
    }

    public function restore($value): Carbon
    {
        return $this->toCarbon($value);
    }

    public function generate()
    {
        return $this->generator()->time();
    }
}
