<?php

namespace Streams\Core\Tests\Field\Type;

use Illuminate\Support\Collection;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Entry\Entry;

class EntriesTest extends TestCase
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
        $type = Streams::make('testing.litmus')->fields->entries->type();

        $entries = new Collection([new Entry([
            'name' => 'First Example',
        ])]);

        $this->assertSame([[
            'name' => 'First Example',
        ]], $type->modify($entries));
    }

    public function test_casts_to_collection_of_entries()
    {
        $type = Streams::make('testing.litmus')->fields->entries->type();

        $this->assertSame('First Example', $type->cast([[
            'name' => 'First Example',
        ]])->first()->name);
    }

    public function test_expanded_value()
    {
        $test = Streams::repository('testing.litmus')->find('field_types');

        $this->assertInstanceOf(EntryInterface::class, $test->expand('entries')->first());
    }

    public function test_can_generate_value()
    {
        $stream = Streams::make('testing.fakers');

        $fake = $stream->fields->entries->type()->generate();

        $this->assertInstanceOf(EntryInterface::class, $fake->first());
        $this->assertIsString($fake->first()->name);
    }
}
