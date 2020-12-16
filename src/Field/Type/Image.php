<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ImageValue;

class Image extends FieldType
{
    /**
     * The class attributes.
     *
     * @var array
     */
    protected $attributes = [];

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
