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
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertSame('Hello String', $test->string);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(StrValue::class, $test->expand('string'));
    }
}
