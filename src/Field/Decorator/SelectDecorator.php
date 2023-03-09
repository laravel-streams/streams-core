<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldDecorator;

class SelectDecorator extends FieldDecorator
{
    public function text()
    {
        if (!$this->value) {
            return null;
        }
        
        return Arr::get($this->field->options(), $this->value) ?: $this->value;
    }

    public function __toString()
    {
        return (string) $this->text();
    }
}
