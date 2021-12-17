<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Value\SelectValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

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

    public function schema()
    {
        $schema = Schema::string($this->field->handle)
            ->description(__($this->field->description))
            ->example($this->generate())
            ->enum(...array_keys($this->options()))
            ->nullable(!$this->field->hasRule('required'));

        if ($default = $this->field->config('default')) {
            $schema = $schema->default($default);
        }

        return $schema;
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
