<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\EncryptedFieldType;
use Streams\Core\Field\Decorator\EncryptedDecorator;

class EncryptedFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_encrypted_string()
    {
        $field = new EncryptedFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame(
            'test@email.com',
            Crypt::decrypt($field->cast('test@email.com'))
        );
    }

    public function test_it_returns_encrypted_decorator()
    {
        $field = new EncryptedFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(
            EncryptedDecorator::class,
            $field->decorate(Crypt::encrypt('test'))
        );
    }
}
