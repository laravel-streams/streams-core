<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ObjectFieldType;

class ObjectFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_json_to_array()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $data = json_decode(json_encode(['foo' => 'Foo', 'bar' => 'Bar']));

        $json = json_encode($data);

        $this->assertEquals($data, $field->cast($json));
    }

    public function test_it_casts_serialized_to_array()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $data = json_decode(json_encode(['foo' => 'Foo', 'bar' => 'Bar']));

        $serialized = serialize($data);

        $this->assertEquals($data, $field->cast($serialized));
    }

    public function test_it_casts_arrays_to_objects()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = ['title' => 'Test Title'];

        $this->assertEquals(json_decode(json_encode($value)), $field->cast($value));
    }

    public function test_it_stores_abstract_types()
    {
        $field = new ObjectFieldType([
            'name' => 'Test Name',
            'stream' => Streams::make('films'),
        ]);

        $this->assertSame([
            '@abstract' => get_class($field),
            'name' => 'Test Name',
        ], $field->modify($field));
    }

    public function test_it_restores_abstract_types()
    {
        $field = new ObjectFieldType([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $restored = $field->restore($field->modify($field));

        $this->assertInstanceOf(ObjectFieldType::class, $restored);
        
        $this->assertSame('Test Name', $restored->name);
    }

    public function test_it_stores_entries()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = new Entry([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $this->assertSame([
            '@stream' => $entry->stream()->id,
            'name' => 'Test Name',
        ], $field->modify($entry));
    }

    public function test_it_restores_entries()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = new Entry([
            'name' => 'Test Name',
            'stream' => Streams::make('films')
        ]);

        $restored = $field->restore($field->modify($entry));

        $this->assertInstanceOf(Entry::class, $restored);
        
        $this->assertSame('Test Name', $restored->name);
    }

    public function test_it_stores_generics()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $this->assertSame([
            'name' => 'Test Name',
        ], $field->modify($entry));
    }

    public function test_it_restores_generics_to_array()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $restored = $field->restore($field->modify($entry));

        $this->assertEquals($entry, $restored);
    }

    public function test_it_restores_generics()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $this->assertSame([
            'name' => 'Test Name',
        ], $field->modify($entry));
    }

    // public function test_it_returns_object()
    // {
    //     $field = new ObjectFieldType([
    //         'stream' => Streams::make('films'),
    //     ]);

    //     $this->assertInstanceOf(Entry::class, $field->decorate([
    //         '@stream' => 'films',
    //     ]));

    //     $this->assertInstanceOf(Entry::class, $field->decorate([
    //         '@stream' => 'films',
    //     ]));
    // }
}
