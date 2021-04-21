<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;

/**
 * Class Arr
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Arr extends FieldType
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
                'array',
            ],
        ], $attributes));
    }

    /**
     * Modify the value for storage.
     *
     * @param $value
     * @return array
     */
    public function modify($value)
    {
        if (is_string($value) && $json = json_decode($value)) {
            $value = $json;
        }

        if (is_string($value) && is_null($json)) {
            $value = explode("\n", $value);
        }
        
        return (array) $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return array
     */
    public function restore($value)
    {
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
        return new ArrValue($value);
    }
}
