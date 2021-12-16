<?php

namespace Streams\Core\Field\Value;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;
use Streams\Core\Field\FieldType;

class Value
{
    use Macroable;
    use ForwardsCalls;

    protected FieldType $type;

    protected mixed $value;

    public function __construct(FieldType $type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType(): FieldType
    {
        return $this->type;
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
