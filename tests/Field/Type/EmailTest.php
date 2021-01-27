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
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertSame('hello@example.com', $test->email);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
    
        $this->assertInstanceOf(EmailValue::class, $test->expand('email'));
    }
}
