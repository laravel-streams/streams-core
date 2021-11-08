<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\UrlValue;
use Streams\Core\Support\Facades\Streams;

class UrlTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->url->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToRoutable()
    {
        $type = Streams::make('testing.litmus')->fields->url->type();

        $url = url('testing');

        $this->assertSame($url, $type->modify($url));
        $this->assertSame($url, $type->restore($url));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(UrlValue::class, $test->expand('url'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertNotFalse(
            filter_var($stream->fields->url->type()->generate(), FILTER_VALIDATE_URL)
        );
    }
}
