<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Stream\Stream;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ObjectFieldType;

class ObjectFieldTypeTest extends CoreTestCase
{
    public function test_it_stores_as_restorable_array()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertSame(Entry::class, $field->modify(new Entry([
            'stream' => 'films',
            '@attributes' => Streams::entries('films')->first(),
        ]))['@abstract']);

        $this->assertSame(ObjectFieldType::class, $field->modify($field)['@abstract']);
    }

    public function test_it_returns_object()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(Entry::class, $field->decorate([
            '@stream' => 'films',
        ]));

        $this->assertInstanceOf(Entry::class, $field->decorate([
            '@stream' => 'films',
        ]));
    }
}
