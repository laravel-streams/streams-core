<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\ImageValue;

class Image extends Str
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return array_merge([
            'rules' => [],
        ], $attributes);
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
