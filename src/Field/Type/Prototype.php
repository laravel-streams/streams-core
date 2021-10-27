<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;

class Prototype extends FieldType
{

    public function modify($value)
    {
        return $value;
    }

    public function restore($value)
    {
        return $this->expand($value);
    }

    public function expand($value)
    {
        return App::make($this->config('abstract'), [
            'attributes' => $value,
        ]);
    }
}
