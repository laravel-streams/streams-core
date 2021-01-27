<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\UrlValue;
use Streams\Core\Field\Value\ColorValue;
use Streams\Core\Support\Facades\Streams;

class UrlTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
    }

    public function testCasting()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertSame('streams.dev', $test->url);
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');
        
        $this->assertInstanceOf(UrlValue::class, $test->expand('url'));
    }
}
