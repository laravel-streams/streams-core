<?php

namespace Streams\Core\Tests\Support;

use Illuminate\Support\Arr;
use Streams\Core\Support\Parser;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\Route;

class ParserTest extends CoreTestCase
{

    public function test_it_returns_data()
    {
        Route::streams('testing/{foo}', 'welcome');

        $this->get('testing/foo');

        $this->assertSame([
            0 => 'timestamp',
            1 => 'request.ip',
            2 => 'request.url',
            3 => 'request.path',
            4 => 'request.root',
            5 => 'request.input',
            6 => 'request.full_url',
            7 => 'request.segments.0',
            8 => 'request.segments.1',
            9 => 'request.uri',
            10 => 'request.query',
            11 => 'request.parsed.scheme',
            12 => 'request.parsed.host',
            13 => 'request.parsed.path',
            14 => 'request.parsed.domain.0',
            15 => 'url.previous',
            16 => 'app.base_path',
            17 => 'user',
            18 => 'route.uri',
            19 => 'route.parameters.foo',
            20 => 'route.parameters.to_urlencoded.foo',
            21 => 'route.parameter_names.0',
            22 => 'route.compiled.static_prefix',
            23 => 'route.compiled.parameters_suffix',
            24 => 'route.prefix',
        ], array_keys(Arr::dot(Parser::data())));
    }
}
