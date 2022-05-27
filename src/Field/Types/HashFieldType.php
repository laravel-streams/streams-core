<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\HashSchema;
use Streams\Core\Field\Decorator\HashDecorator;
use Illuminate\Support\Facades\Hash as HashFacade;

class HashFieldType extends Field
{
    public function cast($value)
    {
        if (strpos($value, '$2y$') === 0 && strlen($value) == 60) {
            return $value;
        }

        return HashFacade::make($value);
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
