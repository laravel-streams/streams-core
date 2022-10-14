<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\Hash;
use Streams\Core\Field\Schema\HashSchema;
use Streams\Core\Field\Decorator\HashDecorator;

class HashFieldType extends Field
{
    public function cast($value)
    {
        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return Hash::make($value);
    }

    public function getSchemaName()
    {
        return HashSchema::class;
    }

    public function getDecoratorName()
    {
        return HashDecorator::class;
    }

    // public function generate()
    // {
    //     return HashFacade::make($this->generator()->text(15, 50));
    // }
}
