<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\DecimalValue;

/**
 * Class Decimal
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Decimal extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
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
        if (is_null($value)) {
            return $value;
        }
        
        return $value;
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

        return $value;
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new DecimalValue($value);
    }
}
