<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;

class Select extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            'rules' => [
                //'in_options',
            ],
        ], $attributes));
    }
}
