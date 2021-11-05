<?php

namespace Streams\Core\Tests\Entry;

use Streams\Core\Entry\Contract\EntryInterface;
use Streams\Core\Entry\EntryFactory;
use Tests\TestCase;
use Streams\Core\Support\Facades\Streams;

class EntryFactoryTest extends TestCase
{

    public function testCanCreateAnEntry()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fake = Streams::make('testing.fakers')->factory()->create();

        $this->assertInstanceOf(EntryInterface::class, $fake);

        $this->assertIsNumeric($fake->id);
    }

    public function testCanCreateAnEntryWithSpecifiedValues()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fake = Streams::make('testing.fakers')->factory()->create([
            'string' => 'Test String',
        ]);

        $this->assertEquals('Test String', $fake->string);
    }

    public function testCanCreateMultipleEntries()
    {
        Streams::load(base_path('vendor/streams/core/tests/fakers.json'));

        $fakes = Streams::make('testing.fakers')->factory()->collect(3);

        $this->assertEquals(3, $fakes->count());

        $this->assertIsNumeric(3, $fakes->first()->id);
        $this->assertInstanceOf(EntryInterface::class, $fakes->first());

        $this->assertIsNumeric(3, $fakes->last()->id);
        $this->assertInstanceOf(EntryInterface::class, $fakes->last());
    }
}
