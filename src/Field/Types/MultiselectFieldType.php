<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Streams\Core\Field\Value\MultiselectValue;
use Streams\Core\Field\Schema\MultiselectSchema;

class MultiselectFieldType extends Field
{
    public function options()
    {
        $options = $this->config('options', []);

        if (is_string($options)) {
            return App::call($options, ['type', $this]);
        }

        return $options;
    }

    public function modify($value)
    {
        if (is_array($value)) {
            return $value;
        }

        return (array) $value;
    }

    public function restore($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $json = json_decode($value, true)) {
            return $json;
        }

        if (is_string($value) && Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        return (array) $value;
    }

    public function getValueName()
    {
        return MultiselectValue::class;
    }

    public function getSchemaName()
    {
        return MultiselectSchema::class;
    }

    public function generate()
    {
        $values = [];

        $keys = array_keys($this->options());

        for ($i = 1; $i <= $this->generator()->numberBetween(1, count($keys)); $i++) {
            $values[] = $this->generator()->randomElement($keys);
        }

        return array_unique($values);
    }

    public function rules()
    {
        return array_merge([
            'in:' . implode(',', array_keys($this->options()))
        ], parent::rules());
    }
}
