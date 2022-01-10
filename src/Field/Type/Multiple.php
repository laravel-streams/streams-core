<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Field;
use Streams\Core\Support\Facades\Streams;

class Multiple extends Field
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
