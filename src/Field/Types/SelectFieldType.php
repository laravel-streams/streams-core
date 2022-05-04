<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Decorator\SelectDecorator;

class SelectFieldType extends Field
{
    public function options(): array
    {
        $options = $this->config('options', []);

        if (is_string($options)) {
            return App::call($options, ['field', $this]);
        }

        return $options;
    }

    public function getDecoratorName()
    {
        return SelectDecorator::class;
    }

    public function rules()
    {
        return array_merge([
            'in:' . implode(',', array_keys($this->options()))
        ], parent::rules());
    }

    // public function generate()
    // {
    //     return $this->generator()->randomElement(array_keys($this->options()));
    // }
}
