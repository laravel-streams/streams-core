<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\EncryptedValue;

class EncryptedFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_does_not_encrypt_when_retreiving_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertSame('itsasecret', Crypt::decrypt($test->encrypted));
    }

    public function test_casts_to_encrypted_string()
    {
        $type = Streams::make('testing.litmus')->fields->encrypted;

        $this->assertSame('test', Crypt::decrypt($type->modify('test')));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EncryptedValue::class, $test->expand('encrypted'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $value = $stream->fields->encrypted->generate();

        $this->assertNotSame($value, Crypt::decrypt($value));
    }
}
