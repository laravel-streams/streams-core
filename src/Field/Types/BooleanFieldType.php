<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Decorator\BooleanDecorator;

class BooleanFieldType extends Field
{
    public function cast($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOL);
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function restore($value)
    {
        return $this->cast($value);
    }

    public function getDecoratorName()
    {
        return BooleanDecorator::class;
    }

    // public function generate()
    // {
    //     return $this->generator()->randomElement([true, false]);
    // }
}
