<?php

namespace Streams\Core\Tests\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Streams\Core\Support\Parser;
use Streams\Core\Tests\CoreTestCase;

class ParserTest extends CoreTestCase
{

    public function test_it_returns_data()
    {
        Route::streams('testing/{foo}', 'welcome');

        $this->get('testing/foo');

        $this->assertSame([
            0 => 'request.url',
            1 => 'request.path',
            2 => 'request.root',
            3 => 'request.input',
            4 => 'request.full_url',
            5 => 'request.segments.0',
            6 => 'request.segments.1',
            7 => 'request.uri',
            8 => 'request.query',
            9 => 'request.parsed.scheme',
            10 => 'request.parsed.host',
            11 => 'request.parsed.path',
            12 => 'request.parsed.domain.0',
            13 => 'url.previous',
            14 => 'user',
            15 => 'route.uri',
            16 => 'route.parameters.foo',
            17 => 'route.parameters.to_urlencoded.foo',
            18 => 'route.parameter_names.0',
            19 => 'route.compiled.static_prefix',
            20 => 'route.compiled.parameters_suffix',
            21 => 'route.prefix',
        ], array_keys(Arr::dot(Parser::data())));
    }
}
