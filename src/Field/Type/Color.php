<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ColorValue;
use Streams\Core\Field\Factory\ColorGenerator;

class Color extends FieldType
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
            'rules' => [],
        ], $attributes));
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return new ColorValue($value);
    }

    public function generator(): ColorGenerator
    {
        return new ColorGenerator($this);
    }
}
