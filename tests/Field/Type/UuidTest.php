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

    public function test_casts_to_string()
    {
        $type = Streams::make('testing.litmus')->fields->uuid->type();

        $this->assertIsString($type->modify((string) Str::uuid()));
        $this->assertIsString($type->restore((string) Str::uuid()));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(StrValue::class, $test->expand('uuid'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->uuid->type()->generate());
    }

    public function test_generates_uuid_as_default()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->uuid->type()->default(null));
    }
}
