<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Facades\Hash;
use Streams\Core\Field\FieldDecorator;

class HashDecorator extends FieldDecorator
{
    public function check($value): bool
    {
        return Hash::check($value, $this->value);
    }
}
