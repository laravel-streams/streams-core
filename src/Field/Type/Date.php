<?php

namespace Streams\Core\Field\Type;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date as DateFacade;

class Date extends Datetime
{
    public function modify($value)
    {
        return $this->toCarbon($value)->format('Y-m-d');
    }

    public function cast($value): Carbon
    {
        return $this->toCarbon($value)->startOfDay();
    }

    public function generate()
    {
        return $this->toCarbon($this->generator()->date());
    }

    public function toCarbon($value): Carbon
    {
        if (is_string($value) && $this->isStandardDateFormat($value)) {
            return DateFacade::instance(Carbon::createFromFormat('Y-m-d', $value)->startOfDay());
        }

        return parent::toCarbon($value)->startOfDay();
    }

    protected function isStandardDateFormat($value): bool
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }
}
