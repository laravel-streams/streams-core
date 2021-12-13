<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Field\Value\MultiselectValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Multiselect extends FieldType
{
    public function options()
    {
        $options = $this->field->config('options', []);

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

    public function expand($value)
    {
        return new MultiselectValue($value);
    }

    public function schema()
    {
        return Schema::array($this->field->handle);
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
}
