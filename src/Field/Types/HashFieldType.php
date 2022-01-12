<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\HashValue;
use Streams\Core\Field\Schema\HashSchema;
use Illuminate\Support\Facades\Hash as HashFacade;

class HashFieldType extends Field
{
    public function modify($value)
    {
        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return HashFacade::make($value);
    }

    public function getValueName()
    {
        return HashValue::class;
    }

    public function getSchemaName()
    {
        return HashSchema::class;
    }

    public function generate()
    {
        return HashFacade::make($this->generator()->text(15, 50));
    }
}
