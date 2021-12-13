<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\IntegerValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Integer extends FieldType
{
    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeAttributes(array $attributes)
    {
        return parent::initializePrototypeAttributes(array_merge([
            'rules' => [
                'numeric',
                'integer',
            ],
        ], $attributes));
    }

    public function default($value)
    {
        if ($value == 'increment') {
            return $this->getNextIncrementValue();
        }
        
        return $this->generate();
    }

    public function modify($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function restore($value)
    {
        if (is_string($value)) {
            $value = preg_replace('/[^\da-z\.\-]/i', '', $value);
        }

        return intval($value);
    }

    public function schema()
    {
        return Schema::integer($this->field->handle);
    }

    public function expand($value)
    {
        return new IntegerValue($value);
    }

    public function generate(): int
    {
        return $this->generator()->randomNumber();
    }

    public function getNextIncrementValue()
    {
        $last = $this->field->stream->entries()->orderBy($this->field->handle, 'DESC')->first();

        if (!$last) {
            return 1;
        }

        return $last->{$this->field->handle} + 1;
    }
}
