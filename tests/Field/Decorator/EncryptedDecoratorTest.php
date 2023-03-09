<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\EncryptedFieldType;

class EncryptedDecoratorTest extends CoreTestCase
{
    public function test_it_returns_decrypted_values()
    {
        $field = new EncryptedFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate($field->cast('I am encrypted'));

        $this->assertSame(
            'I am encrypted',
            $decorator->decrypt()
        );
    }
}
