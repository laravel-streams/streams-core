<?php

namespace Streams\Core\Field\Type;

class Decimal extends Number
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            'rules' => [
                'numeric',
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

        return floatval($value);
    }
}
