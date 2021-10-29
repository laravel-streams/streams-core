<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Factory\IntegerGenerator;

class Integer extends Number
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

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        if (is_null($value = parent::modify($value))) {
            return $value;
        }

        return intval($value);
    }

    public function generator(): IntegerGenerator
    {
        return new IntegerGenerator($this);
    }
}
