<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\NumberValue;

class Decimal extends Number
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
            ],
        ], $attributes));
    }

    public function modify($value)
    {
        if (is_null($value = parent::modify($value))) {
            return $value;
        }

        return round($value, $this->field->config('precision') ?: 1);
    }

    public function restore($value)
    {
        if (is_null($value = parent::restore($value))) {
            return $value;
        }

        return round($value, $this->field->config('precision') ?: 1);
    }

    public function expand($value)
    {
        return new NumberValue($value);
    }
    
    public function generate()
    {
        return number_format(parent::generate(), $this->field->config('precision') ?: 1, '.', '');
    }
}
