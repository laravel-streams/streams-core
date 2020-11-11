<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

/**
 * Class Relationship
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Relationship extends FieldType
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
     * @return EntryInterface|null
     */
    public function expand($value)
    {
        if (isset($this->config['key_name'])) {
            $value = $this->entry->{$this->config['key_name']};
        }

        return Streams::entries($this->config['stream'])->find($value);
    }
}
