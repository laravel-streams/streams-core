<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\App;

class ValidateArrayItems
{
    public function __invoke(Field $field, $value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$allowed = $field->config('items')) {
            return true;
        }

        foreach ($value as $item) {

            if ($this->itemIsValid($item, $allowed, $field)) {
                continue;
            }

            return false;
        }

        return true;
    }

    protected function itemIsValid($item, $config, Field $field): bool
    {
        foreach ($config as $allowed) {

            if (!isset($allowed['type'])) {
                throw new \Exception("The [type] parameter is required when configuring allowed array items.");
            }

            if (!App::has('streams.core.field_type.' . $allowed['type'])) {
                throw new \Exception("Invalid field type [{$allowed['type']}] in array items configuration [{$field->handle}].");
            }

            $field = App::make('streams.core.field_type.' . $allowed['type']);

            if ($field->validator($item)->passes()) {
                return true;
            }
        }

        return false;
    }
}
