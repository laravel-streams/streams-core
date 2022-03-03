<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\FieldDecorator;

class EncryptedDecorator extends FieldDecorator
{
    public function decrypt(): string
    {
        return Crypt::decrypt($this->value);
    }
}
