<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Field\FieldDecorator;

class NumberDecorator extends FieldDecorator
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
