<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class StrValue extends Value
{

    public function lines()
    {
        return explode("\n", $this->value);
    }

    public function __call($method, $arguments)
    {
        return Str::{$method}(...$arguments);
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->value;
    }
}
