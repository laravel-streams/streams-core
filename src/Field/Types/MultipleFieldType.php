<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;

class MultipleFieldType extends Field
{

    public function restore($value)
    {
        return $this->expand($value)->get();
    }

    public function expand($value)
    {
        return Streams::entries($this->config('related'))
            ->where($this->config('key_name', 'id'), 'IN', $value);
    }
}
