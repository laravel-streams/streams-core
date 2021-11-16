<?php

namespace Streams\Core\Tests\Entry;

use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Entry\Contract\EntryInterface;

class EntryFactoryTest extends TestCase
{

    public function test_can_create_entries()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));

        $fake = Streams::make('testing.fakers')->factory()->create();

        $this->assertInstanceOf(EntryInterface::class, $fake);

        $this->assertIsNumeric($fake->integer);
    }

    public function test_can_create_entries_with_specific_values()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));

        $fake = Streams::factory('testing.fakers')->create([
            'string' => 'Test String',
        ]);

        $this->assertEquals('Test String', $fake->string);
    }

    public function test_can_create_multiple_entries()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));
        Streams::load(base_path('vendor/streams/core/tests/examples.json'));

        $fakes = Streams::factory('testing.fakers')->collect(3);

        $this->assertEquals(3, $fakes->count());

        $this->assertIsString($fakes->first()->id);
        $this->assertInstanceOf(EntryInterface::class, $fakes->first());

        $this->assertIsString($fakes->last()->id);
        $this->assertInstanceOf(EntryInterface::class, $fakes->last());
    }
}
