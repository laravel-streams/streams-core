<?php

namespace Streams\Core\Field\Type;

class Multiselect extends Select
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
                //'in_options',
            ],
        ], $attributes));
    }
}
