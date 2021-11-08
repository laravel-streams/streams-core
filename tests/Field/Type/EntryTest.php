<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Field\Value\SelectValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Entry\Contract\EntryInterface;

class EntryTest extends TestCase
{

    public function setUp(): void
    {
        $this->createApplication();

        Streams::load(base_path('vendor/streams/core/tests/litmus.json'));
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));
    }

    public function testNullValues()
    {
        $type = Streams::make('testing.litmus')->fields->entry->type();

        $this->assertNull($type->modify(null));
        $this->assertNull($type->restore(null));
    }

    public function testCastsToEntryInterface()
    {
        $type = Streams::make('testing.litmus')->fields->entry->type();

        // $this->assertSame('foo', $type->modify('foo'));
        // $this->assertSame('bar', $type->restore('bar'));
        $this->markTestSkipped();
    }

    public function testExpandedValue()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EntryInterface::class, $test->expand('entry'));
    }

    public function testCanGenerateValue()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->entry->type()->generate();

        $this->assertInstanceOf(EntryInterface::class, $fake);
        $this->assertIsString($fake->name);
    }
}
