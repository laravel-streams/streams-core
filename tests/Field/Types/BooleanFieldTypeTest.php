<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\BooleanValue;

class BooleanFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_boolean()
    {
        $type = Streams::make('testing.litmus')->fields->boolean;

        $this->assertSame(true, $type->modify(1));
        $this->assertSame(false, $type->modify(0));

        $this->assertSame(true, $type->modify('yes'));
        $this->assertSame(false, $type->modify('no'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(BooleanValue::class, $test->expand('boolean'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsBool($stream->fields->boolean->generate());
    }
}
