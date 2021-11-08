<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Stream\Stream;
use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Arrayable;

class Entry extends FieldType
{

    public function modify($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        // if (is_string($value) && $json = json_decode($value, true)) {
        //     return $json;
        // }

        // if (is_string($value) && Str::isSerialized($value, false)) {
        //     return (array) unserialize($value);
        // }

        if (is_object($value) && $value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return null;
        }

        if (is_string($value) && $json = json_decode($value, true)) {
            $value = $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            $value = (array) unserialize($value);
        }

        return $value;
    }

    public function expand($value)
    {
        return $this->stream()->repository()->newInstance($value);
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
