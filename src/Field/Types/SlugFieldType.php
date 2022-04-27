<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Decorator\StringDecorator;

class SlugFieldType extends Field
{
    public function cast($value)
    {
        return Str::slug($value, $this->config('separator') ?: '-');
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
        return StringDecorator::class;
    }

    // public function generate()
    // {
    //     return $this->modify($this->generator()->words(2, true));
    // }
}
