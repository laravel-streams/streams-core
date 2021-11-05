<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\SelectValue;
use Streams\Core\Support\Facades\Streams;

class SelectTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->select->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToSelectionString()
    {
        $type = Streams::make('testing.litmus')->fields->select->type();

        $this->assertSame('foo', $type->modify('foo'));
        $this->assertSame('bar', $type->restore('bar'));
    }

    public function testConfiguredOptions()
    {
        $type = Streams::make('testing.litmus')->fields->select->type();

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $type->options());
    }

    public function testCallableOptions()
    {
        $type = Streams::make('testing.litmus')->fields->select_callable_options->type();

        $this->assertSame(['foo' => 'Bar'], $type->options());
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(SelectValue::class, $test->expand('select'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $this->assertTrue(in_array(
            $stream->fields->select->type()->generate(),
            array_keys($stream->fields->select->type()->options())
        ));
    }
}


class SelectHandler
{

    public function handle(): array
    {
        return ['foo' => 'Bar'];
    }
}
