<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Schema\SelectSchema;
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

    public function rules(): array
    {
        return array_merge([
            'in:' . implode(',', array_keys($this->options()))
        ], parent::rules());
    }

    public function generator()
    {
        return function () {
            return array_rand($this->options());
        };
    }
    
    public function getSchemaName()
    {
        return SelectSchema::class;
    }

    public function getDecoratorName()
    {
        return SelectDecorator::class;
    }
}
