<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;

class Collection extends FieldType
{

    public function modify($value)
    {
        return $this->expand($value);
    }

    public function restore($value)
    {
        return $this->expand($value);
    }

    public function expand($value)
    {
        if ($value instanceof \Illuminate\Support\Collection) {
            return $value;
        }

        $abstract = $this->config('abstract', \Illuminate\Support\Collection::class);

        return new $abstract((array)$value);
    }
}
