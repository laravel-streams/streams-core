<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\Factory\SlugGenerator;
use Streams\Core\Field\FieldType;

class Slug extends FieldType
{
    /**
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return Str::slug($value, $this->field->config('seperator') ?: '_');
    }

    public function generator(): SlugGenerator
    {
        return new SlugGenerator($this);
    }
}
