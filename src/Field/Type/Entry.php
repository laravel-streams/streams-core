<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Stream\Stream;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Entry\Contract\EntryInterface;

class Entry extends FieldType
{

    public function modify($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_object($value) && $value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }

    public function cast($value)
    {
        if ($value instanceof EntryInterface) {
            return $value;
        }
        
        return $this->stream()->repository()->newInstance($value);
    }

    public function expand($value)
    {
        return $this->cast($value);
    }

    public function generate()
    {
        return $this->stream()->factory()->create();
    }

    public function stream(): Stream
    {
        return Streams::make($this->field->config('stream'));
    }
}
