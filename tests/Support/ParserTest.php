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
            0 => 'request.ip',
            1 => 'request.url',
            2 => 'request.path',
            3 => 'request.root',
            4 => 'request.input',
            5 => 'request.full_url',
            6 => 'request.segments.0',
            7 => 'request.segments.1',
            8 => 'request.uri',
            9 => 'request.query',
            10 => 'request.parsed.scheme',
            11 => 'request.parsed.host',
            12 => 'request.parsed.path',
            13 => 'request.parsed.domain.0',
            14 => 'url.previous',
            15 => 'user',
            16 => 'route.uri',
            17 => 'route.parameters.foo',
            18 => 'route.parameters.to_urlencoded.foo',
            19 => 'route.parameter_names.0',
            20 => 'route.compiled.static_prefix',
            21 => 'route.compiled.parameters_suffix',
            22 => 'route.prefix',
        ], array_keys(Arr::dot(Parser::data())));
    }
}
