<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\EncryptedValue;
use Streams\Core\Field\Types\EncryptedFieldType;

class EncryptedFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_encrypted_value()
    {
        $field = new EncryptedFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(EncryptedValue::class, $field->expand(Crypt::encrypt('test')));
    }
}
