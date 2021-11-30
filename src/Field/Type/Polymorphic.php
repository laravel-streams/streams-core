<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

class Polymorphic extends FieldType
{
    public function modify($value)
    {
        if ($value instanceof EntryInterface) {
            $value = [
                'type' => get_class($value),
                'data' => Arr::make($value),
            ];
        }

        return $value;
    }

    public function restore($value)
    {
        return $this->expand($value);
    }

    public function expand($value)
    {
        if (is_object($value)) {
            return $value;
        }

        $stream = $this->entry->{$this->field->config('morph_type', $this->field . '_type')};
        $key = $this->entry->{$this->field->config('foreign_key', $this->field . '_id')};

        return Streams::entries($stream)->find($key);
    }
}
