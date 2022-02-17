<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\HashValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\HashFieldType;

class HashFieldTypeTest extends CoreTestCase
{

    // public function test_casts_to_hashed_string()
    // {
    //     $type = Streams::make('testing.litmus')->fields->hash;

    //     $this->assertTrue(Hash::check('itsasecret', $type->modify('itsasecret')));
    // }

    public function test_it_returns_hash_value()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(HashValue::class, $field->expand(''));
    }
}
