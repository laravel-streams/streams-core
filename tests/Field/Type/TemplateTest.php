<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Field\Value\StrValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\TemplateValue;

class TemplateTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_string()
    {
        $type = Streams::make('testing.litmus')->fields->template->type();

        $this->assertIsString($type->modify(100));
        $this->assertIsString($type->restore(100));
    }

    public function test_expanded_value()
    {
        $this->markTestIncomplete('This should be "code"');
        return;

        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(TemplateValue::class, $test->expand('template'));
    }

    public function test_can_generate_value()
    {
        $this->markTestIncomplete('This should be "code"');
        return;

        $stream = Streams::make('testing.fakers');

        $this->assertStringContainsString('<html>', $stream->fields->template->type()->generate());
    }
}
