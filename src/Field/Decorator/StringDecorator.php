<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldDecorator;

class StringDecorator extends FieldDecorator
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

    public function __toString()
    {
        return (string) $this->value;
    }
}
