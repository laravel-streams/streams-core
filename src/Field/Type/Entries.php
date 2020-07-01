<?php

namespace Anomaly\Streams\Platform\Field\Type;

use Anomaly\Streams\Platform\Field\FieldType;
use Anomaly\Streams\Platform\Support\Facades\Streams;

/**
 * Class Entries
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Entries extends FieldType
{
    /**
     * The class attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function expand($value)
    {
        return Streams::make($this->stream)
            ->where($this->key_name ? $this->key_name : 'id', 'IN', $value)
            ->get();
    }
}