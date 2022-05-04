<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Decorator\StringDecorator;

class UuidFieldType extends Field
{

    public function default($value)
    {
        return $this->generate();
    }

    public function generate()
    {
        return (string) Str::uuid();
    }

    public function getDecoratorName()
    {
        return StringDecorator::class;
    }
}
