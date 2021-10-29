<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\UrlValue;
use Streams\Core\Field\Factory\UrlGenerator;

class Url extends Str
{
    public function expand($value)
    {
        return new UrlValue($value);
    }

    public function generator(): UrlGenerator
    {
        return new UrlGenerator($this);
    }
}
