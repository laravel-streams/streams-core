<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ImageValue;

class Image extends FieldType
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
            'rules' => [],
        ], $attributes));
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return \Streams\Core\Image\Image
     */
    public function expand($value)
    {
        return new ImageValue($value);
    }
}
