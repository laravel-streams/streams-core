<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Value\StrValue;

class SlugFieldType extends Field
{
    public function modify($value)
    {
        return Str::slug($value, $this->config('seperator') ?: '_');
    }

    public function restore($value)
    {
        return Str::slug($value, $this->config('seperator') ?: '_');
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
