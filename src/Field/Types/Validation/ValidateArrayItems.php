<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Field;

class ValidateArrayItems extends Field
{
    public function __invoke(Field $field, $value)
    {
        if (!is_array($value)) {
            return false;
        }

        if (!$config = $field->config('items')) {
            return true;
        }

        foreach ($value as $item) {

            if ($this->itemIsValid($item, $config)) {
                continue;
            }

            return false;
        }

        return true;
    }

    protected function itemIsValid($item, $config): bool
    {
        foreach ($config as $allowed) {

            if (!isset($allowed['type'])) {
                throw new \Exception("The [type] parameter is required when configuring allowed array items.");
            }

            if ($allowed['type'] == 'array' && is_array($item)) {
                return true;
            }

            if ($allowed['type'] == 'string' && is_string($item)) {
                return true;
            }

            if ($allowed['type'] == 'int' && is_integer($item)) {
                return true;
            }
        }

        return false;
    }
}
