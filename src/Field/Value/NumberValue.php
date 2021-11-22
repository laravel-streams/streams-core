<?php

namespace Streams\Core\Field\Value;

class NumberValue extends Value
{

    public function isEven(): bool
    {
        return $this->value % 2 == 0;
    }
    
    public function isOdd(): bool
    {
        return $this->value % 2 != 0;
    }
}
