<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MarkdownValue;

class MarkdownTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->markdown->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToString()
    {
        $type = Streams::make('testing.litmus')->fields->markdown->type();

        $this->assertIsString($type->modify(100));
        $this->assertIsString($type->restore(100));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(MarkdownValue::class, $test->expand('markdown'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($markdown = $stream->fields->markdown->type()->generate());
        $this->assertStringContainsString('# ', $markdown);
        $this->assertStringContainsString('### ', $markdown);
    }
}
