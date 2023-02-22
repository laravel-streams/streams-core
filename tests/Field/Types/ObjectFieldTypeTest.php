<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ObjectFieldType;

class ObjectFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_json_to_generic()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $data = json_decode(json_encode(['foo' => 'Foo', 'bar' => 'Bar']));

        $json = json_encode($data);

        $this->assertEquals($data, $field->cast($json));
    }

    public function test_it_casts_serialized_to_generic()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $data = json_decode(json_encode(['foo' => 'Foo', 'bar' => 'Bar']));

        $serialized = serialize($data);

        $this->assertEquals($data, $field->cast($serialized));
    }

    public function test_it_casts_to_generic_default()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $value = ['title' => 'Test Title'];

        $this->assertEquals(json_decode(json_encode($value)), $field->cast($value));
    }

    public function test_it_supports_generics()
    {
        $field = new ObjectFieldType([
            'stream' => Streams::make('films')
        ]);

        $entry = json_decode(json_encode([
            'name' => 'Test Name',
        ]));

        $this->assertSame([
            '@generic' => 'stdClass',
            'name' => 'Test Name',
        ], $field->modify($entry));

        $this->assertEquals(
            $entry,
            $field->restore([
                'name' => 'Test Name',
            ])
        );
    }

    public function test_it_supports_entries()
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
    
        $restored = $field->restore($field->modify($entry));

        $this->assertInstanceOf(Entry::class, $restored);

        $this->assertSame('Test Name', $restored->name);
    }

    public function test_it_supports_abstracts()
    {
        $field = new ObjectFieldType([
            'name' => 'Test Name',
            'stream' => Streams::make('films'),
        ]);

        $this->assertSame([
            '@generic' => ObjectFieldTypeTestDummy::class,
            'name' => 'Test Name',
        ], $field->modify(new ObjectFieldTypeTestDummy(...[
            'name' => 'Test Name',
        ])));
    
        $restored = $field->restore($field->modify($field));

        $this->assertInstanceOf(ObjectFieldType::class, $restored);

        $this->assertSame('Test Name', $restored->name);
    }

    public function test_it_validates_types()
    {
        $stream = Streams::build([
            'id' => 'tmp',
            'fields' => [
                [
                    'handle' => 'object',
                    'type' => 'object',
                    'rules' => [
                        'required',
                    ],
                    'config' => [
                        'allowed' => [
                            ['generic' => 'stdClass'],
                            ['stream' => 'planets']
                        ]
                    ],
                ],
            ],
        ]);

        $field = $stream->fields->get('object');

        $generic = json_decode(json_encode(['foo' => 'bar']));
        
        $film = Streams::films()->first();
        $planet = Streams::planets()->first();

        $this->assertFalse($field->validator('Test')->passes());
        $this->assertTrue($field->validator($generic)->passes());

        $this->assertFalse($field->validator($film)->passes());
        $this->assertTrue($field->validator($planet)->passes());
    }

    public function test_it_allows_null_if_not_required()
    {
        $stream = Streams::build([
            'id' => 'tmp',
            'fields' => [
                [
                    'handle' => 'object',
                    'type' => 'object',
                ],
            ],
        ]);

        $field = $stream->fields->get('object');

        $generic = json_decode(json_encode(['foo' => 'bar']));
        
        $this->assertTrue($field->validator(null)->passes());
        $this->assertTrue($field->validator($generic)->passes());
    }
}

class ObjectFieldTypeTestDummy
{
    public function __construct(public string $name)
    {
    }
}
