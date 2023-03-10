<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Field\Schema\EncryptedSchema;
use Streams\Core\Field\Decorator\EncryptedDecorator;

class EncryptedFieldType extends Field
{
    public function cast($value)
    {
        return Crypt::encrypt($value);
    }

    public function generator()
    {
        return function () {

            $string = new StringFieldType([
                'handle' => $this->handle,
                'rules' => $this->rules,
            ]);

            return Crypt::encrypt($string->generate());
        };
    }

    public function getSchemaName()
    {
        return EncryptedSchema::class;
    }

    public function getDecoratorName()
    {
        return EncryptedDecorator::class;
    }
}
