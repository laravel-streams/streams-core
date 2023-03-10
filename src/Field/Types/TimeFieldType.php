<?php

namespace Streams\Core\Field\Types;

use Carbon\Carbon;
use Streams\Core\Field\Schema\TimeSchema;
use Streams\Core\Field\Decorator\DatetimeDecorator;

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

    public function generator()
    {
        return function () {
            return $this->cast(fake()->time());
        };
    }

    public function getSchemaName()
    {
        return TimeSchema::class;
    }
    
    public function getDecoratorName()
    {
        return DatetimeDecorator::class;
    }
}
