<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;

class UuidTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->uuid->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToString()
    {
        $type = Streams::make('testing.litmus')->fields->uuid->type();

        $this->assertIsString($type->modify(Str::uuid()));
        $this->assertIsString($type->restore(Str::uuid()));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(StrValue::class, $test->expand('uuid'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->id->type()->generate());
    }
}
