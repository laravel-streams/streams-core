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

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->string->type();
        
        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToString()
    {
        $type = Streams::make('testing.litmus')->fields->string->type();
        
        $this->assertIsString($type->modify(100));
        $this->assertIsString($type->restore(100));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(StrValue::class, $test->expand('string'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');
        
        $this->assertInstanceOf(StrValue::class, $stream->fields->string->type()->generate());
        $this->assertIsString($stream->fields->string->type()->generate()->value());
    }
}
