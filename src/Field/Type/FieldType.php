<?php

namespace Anomaly\Streams\Platform\Field;

use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Support\Traits\Properties;

/**
 * Class Field
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldType
{
    use HasMemory;
    use Properties;

    /**
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes([
            'name' => null,
            'slug' => null,
            'type' => null,
            'label' => null,
            'stream' => null,
            'warning' => null,
            'placeholder' => null,
            'instructions' => null,

            'unique' => false,
            'required' => false,
            'searchable' => true,
            'translatable' => false,

            'config' => [],
            'rules' => [],
        ]);

        $this->buildProperties();

        $this->fill($attributes);
    }
}
