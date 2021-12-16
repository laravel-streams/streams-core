<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\EmailValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Email extends FieldType
{
    public function modify($value)
    {
        return $this->cast($value);
    }

    public function cast($value)
    {
        if (filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return null;
        }

        return (string) $value;
    }

    public function schema()
    {
        $schema = Schema::string($this->field->handle)
            ->format('email');

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minLength($min);
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxLength($max);
        }

        if ($pattern = $this->field->hasRule('pattern')) {
            $schema = $schema->pattern($pattern);
        }

        if ($default = $this->field->config('default')) {
            $schema = $schema->default($default);
        }

        $schema = $schema->example($this->generate());

        return $schema;
    }

    public function getValueName()
    {
        return EmailValue::class;
    }

    public function generate()
    {
        return $this->generator()->email();
    }
}
