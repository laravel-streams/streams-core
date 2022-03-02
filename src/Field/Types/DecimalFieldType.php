<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\DecimalValue;
use Streams\Core\Field\Schema\DecimalSchema;

class DecimalFieldType extends Field
{

    protected $__attributes = [
        'rules' => [
            'numeric',
        ],
    ];

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function cast($value): float
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        $float = floatval($value);

        if ($float && intval($float) != $float) {
            $value = $float;
        } else {
            $value = intval($value);
        }

        return round($value, $this->config('precision') ?: 1);
    }

    public function getPresenterName()
    {
        return DecimalValue::class;
    }

    public function getSchemaName()
    {
        return DecimalSchema::class;
    }

    public function generate()
    {
        return $this->cast($this->generator()->randomElement([
            $this->generator()->randomNumber(),
            $this->generator()->randomFloat(),
            round($this->generator()->randomFloat(), 1),
        ]));
    }
}
