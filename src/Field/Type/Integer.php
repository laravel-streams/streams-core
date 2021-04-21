<?php

namespace Streams\Core\Field\Type;

class Integer extends Number
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
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
}
