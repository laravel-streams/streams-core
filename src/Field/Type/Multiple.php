<?php

namespace Anomaly\Streams\Platform\Field\Type;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Field\FieldType;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class Multiple
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Multiple extends FieldType
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
     * @return Collection
     */
    public function expand($value)
    {
        return Streams::make($this->config['stream'])
            ->where($this->key_name ? $this->key_name : 'id', 'IN', $value)
            ->get();
    }
}
