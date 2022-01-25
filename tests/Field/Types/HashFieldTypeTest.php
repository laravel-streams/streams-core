<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Streams\Core\Field\Value\HashValue;
use Streams\Core\Support\Facades\Streams;

class HashFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_does_not_hash_when_retreiving_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertTrue(Hash::check('itsasecret', $test->hash));
    }

    public function test_casts_to_hashed_string()
    {
        $type = Streams::make('testing.litmus')->fields->hash;

        $this->assertTrue(Hash::check('itsasecret', $type->modify('itsasecret')));
    }

    public function test_will_not_double_hash_strings()
    {
        $type = Streams::make('testing.litmus')->fields->hash;

        $this->assertTrue(Hash::check('itsasecret', $type->modify($type->modify('itsasecret'))));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(HashValue::class, $test->expand('hash'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->hash->generate());
    }
}
