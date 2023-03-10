<?php

namespace Streams\Core\Tests\Entry;

use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Entry\EntryFactory;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;

class EntryFactoryTest extends CoreTestCase
{
    public function test_it_is_accessible_from_streams()
    {
        $this->assertInstanceOf(EntryFactory::class, Streams::factory('films'));
        $this->assertInstanceOf(EntryFactory::class, Streams::make('films')->factory());
    }

    public function test_it_creates_entry_objects()
    {
        $fake = Streams::factory('vehicles')->create();
        
        $this->assertInstanceOf(Entry::class, $fake);
        
        $this->assertIsInt($fake->crew);
        $this->assertIsNumeric($fake->vehicle_id);
    }

    public function test_it_creates_collections_of_entries()
    {
        $fakes = Streams::factory('vehicles')->collect(5);

        $this->assertSame(5, $fakes->count());

        $this->assertInstanceOf(Entry::class, $fakes->first());
    }

    public function test_it_supports_specific_states()
    {
        $fake = Streams::factory('vehicles')->state([
            'crew' => 100,
        ])->create();

        $this->assertSame(100, $fake->crew);

        $fake = Streams::factory('vehicles')->state(function () {
            return [
                'crew' => 123,
            ];
        })->create();

        $this->assertSame(123, $fake->crew);

        $fake = Streams::factory('vehicles')
            ->state(EntryFactoryTestLargeCrew::class)
            ->create();

        $this->assertSame(850, $fake->crew);
    }
}

class EntryFactoryTestLargeCrew
{
    public function __invoke(array $attributes)
    {
        return ['crew' => 850];
    }
}
