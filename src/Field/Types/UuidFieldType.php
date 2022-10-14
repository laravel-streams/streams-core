<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Schema\UuidSchema;
use Streams\Core\Field\Decorator\StringDecorator;

class UuidFieldType extends Field
{
    public function default($value): string
    {
        return $this->generate();
    }

    public function generate()
    {
        return (string) Str::uuid();
    }

    public function getSchemaName()
    {
        return UuidSchema::class;
    }

    public function getDecoratorName()
    {
        return StringDecorator::class;
    }
}
