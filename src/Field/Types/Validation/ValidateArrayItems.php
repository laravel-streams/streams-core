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
        if (!is_array($value)) {
            return $fail('The :attribute has invalid items.');
        }

        if (!$allowed = $this->field->config('allowed')) {
            return;
        }

        foreach ($value as $item) {

            if ($this->itemIsValid($item, $allowed)) {
                continue;
            }

            return $fail('The :attribute has invalid items.');
        }
    }

    protected function itemIsValid($item, $config): bool
    {
        foreach ($config as $allowed) {

            if (!isset($allowed['type'])) {
                throw new \Exception("The [type] parameter is required when configuring allowed array items.");
            }

            if (!App::has('streams.core.field_type.' . $allowed['type'])) {
                throw new \Exception("Invalid field type [{$allowed['type']}] in array items configuration [{$this->field->handle}].");
            }

            $field = App::make('streams.core.field_type.' . $allowed['type']);

            if ($field->validator($item)->passes()) {
                return true;
            }
        }

        return false;
    }
}
