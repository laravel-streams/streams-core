<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;

class StrTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_string()
    {
        $type = Streams::make('testing.litmus')->fields->string->type();

        $this->assertIsString($type->modify(100));
        $this->assertIsString($type->restore(100));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(StrValue::class, $test->expand('string'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($stream->fields->string->type()->generate());
    }
}
