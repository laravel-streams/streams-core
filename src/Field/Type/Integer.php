<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\IntegerValue;

class Integer extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [
                'numeric',
                'integer',
            ],
        ], $attributes));
    }

    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function expand($value)
    {
        return new IntegerValue($value);
    }

    public function generate(): int
    {
        return $this->generator()->randomNumber();
    }
}
