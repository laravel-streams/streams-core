<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Streams\Core\Stream\Stream;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Entry\EntrySchema;
use Streams\Core\Entry\EntryFactory;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Repository\Contract\RepositoryInterface;

class StreamManagerTest extends TestCase
{

    public function test_can_build_a_stream_from_array()
    {
        $stream = Streams::build([
            'id' => 'testing.build'
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertFalse(Streams::exists('testing.build'));
    }

    public function test_can_register_a_stream_from_array()
    {
        $stream = Streams::register([
            'id' => 'testing.register',
            'fields' => [
                'name' => 'string',
            ]
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertTrue(Streams::exists('testing.register'));
    }

    public function test_throws_exception_if_stream_is_not_registed()
    {
        $this->expectException(\Exception::class);

        Streams::make('foo.bar');
    }

    public function test_can_load_stream_from_json_file()
    {
        $stream = Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertTrue(Streams::exists('testing.litmus'));
    }

    public function test_can_extend_a_registered_stream()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $stream = Streams::extend('testing.litmus', [
            'id' => 'testing.litmus_extended',
            'description' => 'Extended description.',
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertSame('Extended description.', $stream->description);
    }

    public function test_can_overload_a_registered_stream()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $stream = Streams::overload('testing.litmus', [
            'description' => 'New description.',
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertSame('New description.', $stream->description);
    }

    public function test_collection_contains_registered_streams()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertTrue(Streams::collection()->has('testing.litmus'));
    }

    public function test_routes_registered_streams()
    {
        $stream = Streams::register([
            'id' => 'testing.test_routes',
            'routes' => [
                'view' => [
                    'uri' => 'testing/{id}',
                ],
                'index' => [
                    'uri' => 'testing/{id}',
                    'defer' => true,
                ],
            ]
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertTrue(Streams::exists('testing.test_routes'));
    }

    public function test_returns_entry_criteria()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(Criteria::class, Streams::entries('testing.litmus'));
    }

    public function test_returns_entry_repository()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(RepositoryInterface::class, Streams::repository('testing.litmus'));
    }

    public function test_returns_entry_factory()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(EntryFactory::class, Streams::factory('testing.litmus'));
    }

    public function test_returns_schema_generator()
    {
        Streams::load(__DIR__ . '/../litmus.json');

        $this->assertInstanceOf(EntrySchema::class, Streams::schema('testing.litmus'));
    }
}
