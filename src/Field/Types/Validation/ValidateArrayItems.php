<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateArrayItems implements InvokableRule
{
    public function __construct(public Field $field)
    {
    }

    public function __invoke($attribute, $value, $fail)
    {
        $value = $this->field->cast($value);

        if (!is_array($value)) {
            return $fail('The :attribute has invalid items.');
        }

        if (!$items = $this->field->config('items')) {
            return;
        }

        if ($this->field->config('enforce_items', true) === false) {
            return;
        }

        foreach ($value as $item) {

            if ($this->itemIsValid($item, $items)) {
                continue;
            }

            return $fail('The :attribute has invalid items.');
        }
    }

    protected function itemIsValid($value, $items): bool
    {
        foreach ($items as $item) {

            if (!isset($item['type'])) {
                throw new \Exception("The [type] parameter is required when configuring item types.");
            }

            if (!App::has('streams.core.field_type.' . $item['type'])) {
                throw new \Exception("Invalid field type [{$item['type']}] in items configuration [{$this->field->handle}].");
            }

            $field = App::make('streams.core.field_type.' . $item['type']);

            if ($field->validator($value)->passes()) {
                return true;
            }
        }

        return false;
    }
}
