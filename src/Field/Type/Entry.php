<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Stream\Stream;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Factory\EntryGenerator;

class Entry extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    // protected function initializePrototypeAttributes(array $attributes)
    // {
    //     return parent::initializePrototypeAttributes(array_merge([
    //         'rules' => [],
    //     ], $attributes));
    // }

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
        return $this->stream()->newInstance($value);
    }

    public function generator(): EntryGenerator
    {
        return new EntryGenerator($this);
    }

    public function stream(): Stream
    {
        return Streams::make($this->field->config('related'));
    }
}
