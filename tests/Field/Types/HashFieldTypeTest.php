<?php

namespace Streams\Core\Tests\Field\Types;

use Illuminate\Support\Facades\Hash;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\HashFieldType;
use Streams\Core\Field\Presenter\HashPresenter;

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

    public function test_it_returns_hash_presenter()
    {
        $field = new HashFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(HashPresenter::class, $field->decorate(''));
    }
}
