<?php

namespace Streams\Core\Field\Types;

use Carbon\Carbon;
use Streams\Core\Field\Field;
use Illuminate\Support\Facades\Date;
use Streams\Core\Field\Schema\DatetimeSchema;
use Streams\Core\Field\Decorator\DatetimeDecorator;

class DatetimeFieldType extends Field
{
    #[Field([
        'type' => 'object',
        'config' => [
            'wrapper' => 'array',
        ],
    ])]
    public array $config = [
        'format' => 'Y-m-d H:i:s',
    ];

    public function cast($value): \Datetime
    {
        return $this->toCarbon($value);
    }

    public function modify($value)
    {
        return $this->toCarbon($value)->format($this->config('format'));
    }

    public function restore($value): \Datetime
    {
        return $this->cast($value);
    }

    public function getSchemaName()
    {
        return DatetimeSchema::class;
    }

    public function getDecoratorName()
    {
        return DatetimeDecorator::class;
    }

    // public function generate()
    // {
    //     return $this->cast($this->generator()->dateTime());
    // }

    protected function toCarbon($value): Carbon
    {
        if ($value instanceof Carbon) {
            return Date::instance($value);
        }

        if ($value instanceof \Datetime) {
            return Date::parse(
                $value->format($this->config('format')),
                $value->getTimezone()
            );
        }

        if (is_numeric($value)) {
            return Date::createFromTimestamp($value);
        }

        return Date::parse($value);
    }
}
