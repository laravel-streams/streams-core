<?php

namespace Streams\Core\Tests\Stream;

use Streams\Core\Stream\Stream;
use Streams\Core\Criteria\Criteria;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Route;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Streams;

class StreamManagerTest extends CoreTestCase
{

    public function test_it_builds_streams()
    {
        $stream = Streams::build([
            'id' => 'testing.build'
        ]);

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertFalse(Streams::exists('testing.build'));
    }

    public function test_it_registers_streams()
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

    public function test_it_throws_exception_if_stream_is_not_registed()
    {
        $this->expectException(\Exception::class);

        Streams::make('foo.bar');
    }

    public function test_it_loads_streams_from_file()
    {
        $stream = Streams::load(base_path('streams/films.json'));

        $this->assertInstanceOf(Stream::class, $stream);

        $this->assertTrue(Streams::exists('films'));
    }

    public function test_it_extends_registered_streams()
    {
        $stream = Streams::extend('films', [
            'id' => 'animated_films',
            'description' => 'Animated films.',
        ]);

        $this->assertSame('Animated films.', $stream->description);
    }

    public function test_it_overloads_registered_streams()
    {
        $stream = Streams::overload('films', [
            'description' => 'New description.',
        ]);

        $this->assertSame('New description.', $stream->description);

        $this->assertNull(Streams::make('films')->description);
    }

    public function test_it_returns_registered_streams()
    {
        $this->assertTrue(Streams::collection()->has('films'));
    }

    public function test_it_routes_registered_streams()
    {
        $stream = Streams::register([
            'id' => 'test_routes',
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

        $this->assertTrue(Route::has('test_routes.view'));
    }

    public function test_it_returns_entry_criteria()
    {
        $this->assertInstanceOf(Criteria::class, Streams::entries('films'));
    }

    public function test_it_returns_entry_repository()
    {
        $this->assertInstanceOf(Repository::class, Streams::repository('films'));
    }

    public function test_it_parses_schema()
    {
        Streams::parse(file_get_contents('https://raw.githubusercontent.com/OAI/OpenAPI-Specification/main/examples/v3.0/petstore.yaml'));

        $this->assertTrue(Streams::collection()->has('Pets'));
    }
}
