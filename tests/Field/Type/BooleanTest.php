<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\BooleanValue;

class BooleanTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_boolean()
    {
        $type = Streams::make('testing.litmus')->fields->boolean->type();

        $this->assertSame(true, $type->cast(1));
        $this->assertSame(false, $type->cast(0));

        $this->assertSame(true, $type->cast('yes'));
        $this->assertSame(false, $type->cast('no'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(BooleanValue::class, $test->expand('boolean'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsBool($stream->fields->boolean->type()->generate());
    }
}
