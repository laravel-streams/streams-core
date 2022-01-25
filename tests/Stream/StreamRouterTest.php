<?php

namespace Streams\Core\Tests\Stream;

use Tests\TestCase;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class StreamRouterTest extends TestCase
{

    public function test_registers_routes()
    {
        Router::streams('testing/{id}', [
            'stream' => 'testing.examples',
            'defer' => true
        ]);

        Router::streams('testing2/{id}', 'App\Test@handle');
        Router::streams('testing3/{id}', 'test.view');

        $this->assertInstanceOf(Route::class, app(Router::class)->get('testing/{id}'));
    }
}
