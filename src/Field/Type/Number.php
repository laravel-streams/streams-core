<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\NumberValue;
use Streams\Core\Field\Schema\NumberSchema;

class Number extends FieldType
{
    
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [
                'numeric',
            ],
        ], $attributes));
    }

    public function modify($value)
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

        return $value;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        $float = floatval($value);

        if ($float && intval($float) != $float) {
            $value = $float;
        } else {
            $value = intval($value);
        }

        return $value;
    }

    public function getValueName()
    {
        return NumberValue::class;
    }

    public function getSchemaName()
    {
        return NumberSchema::class;
    }

    public function generate()
    {
        return $this->generator()->randomElement([
            $this->generator()->randomNumber(),
            $this->generator()->randomFloat(),
            round($this->generator()->randomFloat(), 1),
        ]);
    }
}
