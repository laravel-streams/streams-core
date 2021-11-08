<?php

namespace Streams\Core\Tests\Field\Type;

use Streams\Core\Field\Value\ColorValue;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class ColorTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->color->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToString()
    {
        $type = Streams::make('testing.litmus')->fields->color->type();

        $this->assertSame('#ffffff', $type->modify('#ffffff'));
        $this->assertSame('#000000', $type->restore('#000000'));
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(ColorValue::class, $test->expand('color'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $color = substr($stream->fields->color->type()->generate(), 1);

        $this->assertTrue(ctype_xdigit($color) && strlen($color) == 6);
    }
}
