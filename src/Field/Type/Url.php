<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\UrlValue;

class Url extends Str
{
    public function expand($value)
    {
        return new UrlValue($value);
    }
}
