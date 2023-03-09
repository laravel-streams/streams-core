<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Decorator\FileDecorator;

class FileFieldType extends StringFieldType
{
    public function cast($value)
    {
        if (is_string($value)) {
            return $value;
        }

        throw new \Exception("Could not determine file type.");
    }

    public function getDecoratorName()
    {
        return FileDecorator::class;
    }
}
