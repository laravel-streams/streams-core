<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Slug extends FieldType
{
    public function modify($value)
    {
        return Str::slug($value, $this->field->config('seperator') ?: '_');
    }

    public function restore($value)
    {
        return Str::slug($value, $this->field->config('seperator') ?: '_');
    }

    public function expand($value)
    {
        return new StrValue($value);
    }

    public function schema()
    {
        return Schema::string($this->field->handle);
    }
    
    public function generate()
    {
        return $this->modify($this->generator()->words(2, true));
    }
}
