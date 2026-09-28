<?php

namespace Streams\Core\Tests\Stream;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Streams\Core\Stream\StreamRouter;
use Streams\Core\Tests\CoreTestCase;

class StreamRouterTest extends CoreTestCase
{
    public function test_it_registers_routes()
    {
        Router::streams('testing/{id}', [
            'stream' => 'films',
            'defer' => true
        ]);

        Router::streams('testing2/{id}', 'App\Test@handle');
        Router::streams('testing3/{id}', 'test.view');

        $this->assertInstanceOf(Route::class, app(Router::class)->get('testing/{id}'));
    }

    public function test_it_applies_constraints_written_as_a_map()
    {
        $route = StreamRouter::route('map/{id}/{slug}', [
            'stream' => 'films',
            'constraints' => [
                'id' => '[0-9]+',
                'slug' => '[a-z-]+',
            ],
        ]);

        $this->assertSame(['id' => '[0-9]+', 'slug' => '[a-z-]+'], $route->wheres);

        $this->assertTrue($route->matches(Request::create('map/12/a-new-hope')));
        $this->assertFalse($route->matches(Request::create('map/abc/a-new-hope')));
        $this->assertFalse($route->matches(Request::create('map/12/A_NEW_HOPE')));
    }

    public function test_it_applies_constraints_decoded_from_json_objects()
    {
        $definition = json_decode('{"stream": "films", "constraints": {"id": "[0-9]+"}}');

        $route = StreamRouter::route('object/{id}', [
            'stream' => $definition->stream,
            'constraints' => $definition->constraints,
        ]);

        $this->assertSame(['id' => '[0-9]+'], $route->wheres);
    }

    public function test_it_applies_every_constraint_in_a_list_of_maps()
    {
        $route = StreamRouter::route('list/{id}/{slug}', [
            'stream' => 'films',
            'constraints' => [
                ['id' => '[0-9]+'],
                ['slug' => '[a-z-]+'],
            ],
        ]);

        $this->assertSame(['id' => '[0-9]+', 'slug' => '[a-z-]+'], $route->wheres);

        $this->assertTrue($route->matches(Request::create('list/4/empire')));
        $this->assertFalse($route->matches(Request::create('list/4/EMPIRE')));
    }

    public function test_it_keeps_the_legacy_name_pattern_pair()
    {
        $route = StreamRouter::route('pair/{id}', [
            'stream' => 'films',
            'constraints' => ['id', '[0-9]+'],
        ]);

        $this->assertSame(['id' => '[0-9]+'], $route->wheres);
    }

    public function test_it_applies_a_list_of_name_pattern_pairs()
    {
        $route = StreamRouter::route('pairs/{id}/{slug}', [
            'stream' => 'films',
            'constraints' => [['id', '[0-9]+'], ['slug', '[a-z-]+']],
        ]);

        $this->assertSame(['id' => '[0-9]+', 'slug' => '[a-z-]+'], $route->wheres);
    }

    public function test_it_ignores_empty_constraints()
    {
        $route = StreamRouter::route('empty/{id}', [
            'stream' => 'films',
            'constraints' => [],
        ]);

        $this->assertSame([], $route->wheres);
    }

    public function test_stream_route_definitions_apply_map_constraints()
    {
        Router::streams('macro/{id}', [
            'stream' => 'films',
            'constraints' => ['id' => '[0-9]+'],
        ]);

        $route = app('router')->getRoutes()->match(Request::create('macro/7'));

        $this->assertSame(['id' => '[0-9]+'], $route->wheres);
    }
}
