<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\HashValue;
use Streams\Core\Support\Facades\Streams;

class HashTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->hash->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToString()
    {
        $type = Streams::make('testing.litmus')->fields->hash->type();

        $this->assertIsString($hash = $type->modify("Hash me!"));
        $this->assertSame($hash, $type->restore($hash));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(HashValue::class, $test->expand('hash'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->hash->type()->generate());
    }
}
