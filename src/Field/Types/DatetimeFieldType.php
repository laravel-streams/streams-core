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

    public function default($value)
    {
        return $this->toCarbon($value);
    }

    public function cast($value): \Datetime | null
    {
        return $this->toCarbon($value);
    }

    public function modify($value)
    {
        $format = $this->config('format', 'Y-m-d H:i:s');

        return $this->toCarbon($value)?->format($format);
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

    public function generator()
    {
        $min = $this->ruleParameter('min');
        $max = $this->ruleParameter('max');

        if ($min || $max) {
            return function () use ($min, $max) {
                return $this->cast(fake()->dateTimeBetween($min, $max));
            };
        }

        return function () {
            return $this->cast(fake()->dateTime());
        };
    }

    protected function toCarbon($value): Carbon | null
    {
        if (!$value) {
            return null;
        }
        
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
