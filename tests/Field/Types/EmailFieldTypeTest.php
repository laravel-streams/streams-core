<?php

namespace Streams\Core\Tests\Field\Types;

use Tests\TestCase;
use Streams\Core\Field\Value\EmailValue;
use Streams\Core\Support\Facades\Streams;

class EmailFieldTypeTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function test_casts_to_email()
    {
        $type = Streams::make('testing.litmus')->fields->email;

        $this->assertSame('test@domain.com', $type->modify('test@domain.com'));
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EmailValue::class, $test->expand('email'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertNotFalse(
            filter_var($stream->fields->email->generate(), FILTER_VALIDATE_EMAIL)
        );
    }
}
