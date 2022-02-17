<?php

namespace Streams\Core\Tests\Stream;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
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
}
