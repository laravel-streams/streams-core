<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

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
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param $value
     * @return string
     */
    public function restore($value)
    {
        return $this->expand($value);
    }

    /**
     * Expand the value.
     *
     * @param $value
     * @return Collection
     */
    public function expand($value)
    {
        return Streams::entries($this->config['stream'])
            ->where($this->key_name ? $this->key_name : 'id', 'IN', $value)
            ->get();
    }
}
