<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

/**
 * Class Polymorphic
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Polymorphic extends FieldType
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
        $stream = $this->entry->{Arr::get($this->config, 'morph_type', $this->field . '_type')};
        $key = $this->entry->{Arr::get($this->config, 'foreign_key', $this->field . '_id')};
        
        return Streams::entries('pages_default')->find($key);
    }
}
