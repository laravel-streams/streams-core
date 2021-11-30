<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Support\Facades\Streams;

class Multiple extends FieldType
{

    public function restore($value)
    {
        return $this->expand($value)->get();
    }

    public function expand($value)
    {
        return Streams::entries($this->field->config('related'))
            ->where($this->field->config('key_name', 'id'), 'IN', $value);
    }
}
