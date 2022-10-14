<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\PolymorphicFieldType;

class PolymorphicFieldTypeTest extends CoreTestCase
{
    public function test_it_stores_entries()
    {
        $field = new PolymorphicFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = new Entry([
            'episode_id' => 101,
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([
            '@stream' => $entry->stream()->id,
            'episode_id' => 101,
        ], $field->modify($entry));
    }

    public function test_it_restores_entries()
    {
        $field = new PolymorphicFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = Streams::entries('films')->first();

        $restored = $field->restore($field->modify($entry));

        $this->assertInstanceOf(Entry::class, $restored);
        
        $this->assertSame('A New Hope', $restored->title);
    }
}
