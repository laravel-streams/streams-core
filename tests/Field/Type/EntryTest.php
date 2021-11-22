<?php

namespace Streams\Core\Tests\Field\Type;

use Tests\TestCase;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
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

    public function test_stores_values_as_array()
    {
        $type = Streams::make('testing.litmus')->fields->entry->type();

        $entry = new Entry([
            'name' => 'First Example',
        ]);

        $this->assertSame([
            'name' => 'First Example',
        ], $type->modify($entry));
    }

    public function test_casts_to_entry_interface()
    {
        $type = Streams::make('testing.litmus')->fields->entry->type();

        $this->assertSame('First Example', $type->cast([
            'name' => 'First Example',
        ])->name);
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EntryInterface::class, $test->expand('entry'));
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->entry->type()->generate();

        $this->assertIsString($fake->name);
    }
}
