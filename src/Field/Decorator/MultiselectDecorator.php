<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Streams\Core\Field\FieldDecorator;

class MultiselectDecorator extends FieldDecorator
{
    public function selected()
    {
        if (!$this->value) {
            return null;
        }
        
        $options = $this->field->options();

        return array_combine(
            $this->value,
            array_map(function ($value) use ($options) {
                return (Arr::get($options, $value) ?: $value);
            }, $this->value ?: [])
        );
    }
}
