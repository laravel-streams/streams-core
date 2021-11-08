<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\EmailValue;
use Streams\Core\Support\Facades\Streams;

class EmailTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->email->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToEmail()
    {
        $type = Streams::make('testing.litmus')->fields->email->type();

        $this->assertNull($type->modify('test'));
        $this->assertNull($type->restore('test'));

        $this->assertSame('test@domain.com', $type->modify('test@domain.com'));
        $this->assertSame('test@domain.com', $type->restore('test@domain.com'));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EmailValue::class, $test->expand('email'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertNotFalse(
            filter_var($stream->fields->email->type()->generate(), FILTER_VALIDATE_EMAIL)
        );
    }
}
