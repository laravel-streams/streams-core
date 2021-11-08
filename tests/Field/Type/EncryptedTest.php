<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Illuminate\Support\Facades\Crypt;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\EncryptedValue;

class EncryptedTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->encrypted->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToEncryptedString()
    {
        $type = Streams::make('testing.litmus')->fields->encrypted->type();

        $this->assertSame('test', Crypt::decrypt($type->modify('test')));
        $this->assertSame('test', $type->restore('test'));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EncryptedValue::class, $test->expand('encrypted'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $value = $stream->fields->encrypted->type()->generate();

        $this->assertNotSame($value, Crypt::decrypt($value));
    }
}
