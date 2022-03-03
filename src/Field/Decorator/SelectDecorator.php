<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldDecorator;

class SelectDecorator extends FieldDecorator
{
    public function value()
    {
        return Arr::get($this->field->options(), $this->value);
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
