<?php

namespace Streams\Core\Field;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;

class FieldDecorator
{
    use ForwardsCalls;
    use Macroable;

    public $value;

    protected Field $field;

    public function __construct(Field $field, $value)
    {
        $this->value = $value;
        $this->field = $field;
    }

    public function getField(): Field
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->value, $method, $parameters);
    }

    public function __get($property)
    {
        return $this->value->{$property};
    }
}
