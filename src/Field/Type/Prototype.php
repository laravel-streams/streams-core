<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Schema\PrototypeSchema;

class Prototype extends FieldType
{

    public function modify($value)
    {
        return Arr::make($value);
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

        return App::make($this->field->config('abstract'), [
            'attributes' => $value,
        ]);
    }

    public function getSchemaName()
    {
        return PrototypeSchema::class;
    }
}
