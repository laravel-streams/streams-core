<?php

namespace Streams\Core\Tests\Http\Controller;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Streams\Core\Tests\CoreTestCase;
use Streams\Testing\TestServiceProvider;
use Streams\Core\Support\Facades\Streams;

class EntryControllerTest extends CoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $stream = Streams::overload('films', [
            'routes' => [
                'index' => [
                    'uri' => 'films',
                    'view' => 'streams-testing::films',
                ],
                'view' => [
                    'uri' => 'films/{id}',
                    'view' => 'streams-testing::film',
                ],
            ],
        ]);

        Streams::route($stream);

        App::register(TestServiceProvider::class);
    }

    public function test_it_returns_stream_views()
    {
        $response = $this->get('films');

        $response->assertSee('The Empire Strikes Back');
        $response->assertSee('Return of the Jedi');
    }

    public function test_it_returns_entry_views()
    {
        $response = $this->get('films/6');

        $response->assertSee('Return of the Jedi');
    }

    public function test_it_returns_404_when_entry_does_not_exist()
    {
        $response = $this->get('films/600');

        $response->assertStatus(404);
    }

    public function test_it_resolves_route_actions()
    {
        Route::streams('testing-route-actions', [
            'view' => 'streams-testing::entry',
            'stream' => 'planets',
            'entry' => 4,
        ]);

        $response = $this->get('testing-route-actions');

        $response->assertSee('Hoth');
    }

    public function test_it_resolves_uri_parameters()
    {
        Route::streams('testing-uri-parameters/{stream}', [
            'view' => 'streams-testing::entries',
        ]);

        Route::streams('testing-uri-parameters/{stream}/{id}', [
            'view' => 'streams-testing::entry',
        ]);

        Route::streams('testing-uri-entry-parameter/{stream}/{entry}', [
            'view' => 'streams-testing::entry',
        ]);

        $response = $this->get('testing-uri-parameters/planets');
        
        $response->assertSee('Hoth');
        $response->assertSee('Dagobah');

        $response = $this->get('testing-uri-parameters/planets/4');
        
        $response->assertSee('Hoth');

        $response = $this->get('testing-uri-entry-parameter/planets/5');

        $response->assertSee('Dagobah');
    }

    public function test_it_resolves_query_parameters()
    {
        Route::streams('testing-query-parameters/{entry.name}', [
            'view' => 'streams-testing::entry',
            'stream' => 'planets',
        ]);

        $response = $this->get('testing-query-parameters/Hoth');

        $response->assertSee('Hoth');
    }
}
