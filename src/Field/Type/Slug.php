<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\StrValue;

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

    public function getValueName()
    {
        return StrValue::class;
    }

    public function generate()
    {
        return $this->modify($this->generator()->words(2, true));
    }
}
