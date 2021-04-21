<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

class Str extends FieldType
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
            'rules' => [],
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
        if (is_null($value)) {
            return $value;
        }
        
        return (string) $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }
        
        return (string) $value;
    }


    /**
     * Expand the value.
     *
     * @param $value
     * @return StrValue
     */
    public function expand($value)
    {
        return new StrValue($value);
    }
}
