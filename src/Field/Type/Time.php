<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

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

    public function schema()
    {
        return Schema::string($this->field->handle)
            ->pattern('^(?:(?:([01]?\d|2[0-3]):)?([0-5]?\d):)?([0-5]?\d)$');
    }

    public function generate()
    {
        return $this->generator()->time();
    }
}
