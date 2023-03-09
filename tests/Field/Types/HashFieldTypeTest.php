<?php

namespace Streams\Core\Tests\Field\Types;

use Illuminate\Support\Facades\Hash;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Schema\HashSchema;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\HashFieldType;
use Streams\Core\Field\Decorator\HashDecorator;

class HashFieldTypeTest extends CoreTestCase
{

    public function test_it_casts_to_hashed_string()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertTrue(Hash::check('itsasecret', $field->cast('itsasecret')));
    }

    public function test_it_does_not_double_hash()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertTrue(
            Hash::check('itsasecret', $field->cast(Hash::make('itsasecret')))
        );
    }

    public function test_it_returns_hash_decorator()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(HashDecorator::class, $field->decorate(''));
    }

    public function test_it_returns_hash_schema()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(HashSchema::class, $field->schema());
    }
}
