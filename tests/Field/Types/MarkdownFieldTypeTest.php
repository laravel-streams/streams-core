<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MarkdownValue;

class MarkdownFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(MarkdownValue::class, $test->expand('markdown'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertIsString($markdown = $stream->fields->markdown->generate());
        
        $this->assertStringContainsString('# ', $markdown);
        $this->assertStringContainsString('### ', $markdown);
    }
}
