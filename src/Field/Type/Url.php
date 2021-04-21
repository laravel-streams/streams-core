<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\UrlValue;

class Url extends Str
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
                //'valid_target',
            ],
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
        return new UrlValue($value);
    }
}
