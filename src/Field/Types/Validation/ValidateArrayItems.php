<?php

namespace Streams\Core\Field\Types\Validation;

use Streams\Core\Field\Field;

use function GuzzleHttp\Promise\all;

class ValidateArrayItems extends Field
{
    public function __construct(
        public Field $field
    ) {
    }

    public function __invoke($value)
    {
        if (!$this->field->config('items')) {
            return true;
        }

        foreach ($value as $key => $value) {

            if ($this->validateItems($value)) {
                continue;
            }

            return false;
        }

        return true;
    }

    protected function validateItems($value)
    {
        $items = $this->field->config('items');

        foreach ($items as $allowed) {

            if ($this->validateItem($value, $allowed)) {
                continue;
            }

            return false;
        }
    }

    protected function validateItem(mixed $value, array $allowed = [])
    {
        if (!isset($allowed['type'])) {
            throw new \Exception("The [type] parameter is required when configuring allowed array items.");
        }

        if ($allowed['type'] == 'array' && is_array($value)) {
            return true;
        }

        if ($allowed['type'] == 'string' && is_string($value)) {
            return true;
        }

        if ($allowed['type'] == 'int' && is_integer($value)) {
            return true;
        }

        dump($allowed);
        dd($value);

        return false;
    }
}
