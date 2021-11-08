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

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->slug->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToSlugString()
    {
        $field = Streams::make('testing.litmus')->fields->slug;

        $type = $field->type();

        $this->assertSame('test_slug', $type->modify('Test Slug'));
        $this->assertSame('test_slug', $type->restore('Test Slug'));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(StrValue::class, $test->expand('slug'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertStringContainsString('_', $stream->fields->slug->type()->generate());
    }
}
