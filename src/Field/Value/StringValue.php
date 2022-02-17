<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class StringValue extends Value
{

    public function lines()
    {
        return explode("\n", $this->value);
    }

    public function render(array $payload = [])
    {
        return Str::markdown(View::parse($this->value, $payload));
    }

    public function __call($method, $arguments)
    {
        return Str::{$method}($this->value, ...$arguments);
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
