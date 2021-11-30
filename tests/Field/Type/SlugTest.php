<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;

class SlugTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_slug_string()
    {
        $field = Streams::make('testing.litmus')->fields->slug;

        $type = $field->type();

        $this->assertSame('test_slug', $type->modify('Test Slug'));
        $this->assertSame('test_slug', $type->restore('Test Slug'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(StrValue::class, $test->expand('slug'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertStringContainsString('_', $stream->fields->slug->type()->generate());
    }
}
