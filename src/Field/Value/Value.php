<?php

namespace Streams\Core\Field\Value;

use Streams\Core\Field\Field;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;

class Value
{
    use Macroable;
    use ForwardsCalls;

    protected Field $field;

    protected mixed $value;

    public function __construct(Field $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
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
}
