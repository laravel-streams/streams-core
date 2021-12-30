<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Value\SelectValue;
use Streams\Core\Field\Schema\SelectSchema;

class Select extends FieldType
{

    public function options(): array
    {
        $options = $this->field->config('options', []);

        if (is_string($options)) {
            return App::call($options, ['type', $this]);
        }

        return $options;
    }

    public function getValueName()
    {
        return SelectValue::class;
    }

    public function getSchemaName()
    {
        return SelectSchema::class;
    }

    public function rules()
    {
        return array_merge([
            'in:' . implode(',', array_keys($this->options()))
        ], parent::rules());
    }

    public function generate()
    {
        return $this->generator()->randomElement(array_keys($this->options()));
    }
}
