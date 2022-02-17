<?php

namespace Streams\Core\Tests\Entry;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Entry\Contract\EntryInterface;

class EntryFactoryTest extends CoreTestCase
{
    public function test_it_creates_entries()
    {
        $integer = Streams::make('films')->factory()->create();

        $this->assertInstanceOf(EntryInterface::class, $integer);

        $this->assertEquals(8, $integer->episode_id);
    }

    public function test_it_creates_entries_with_specified_values()
    {
        $entry = Streams::factory('films')->create([
            'title' => 'Test String',
        ]);

        $this->assertEquals('Test String', $entry->title);
    }

    public function test_it_creates_multiple_entries()
    {
        $entries = Streams::factory('films')->collect(3);

        $this->assertEquals(3, $entries->count());

        $this->assertEquals(8, $entries->first()->episode_id);
        $this->assertEquals(10, $entries->last()->episode_id);
    }
}
