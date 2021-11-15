<?php

namespace Streams\Core\Tests\Support;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Streams\Core\Support\Parser;

class ParserTest extends TestCase
{

    public function test_data_structure()
    {
        $this->assertSame([
            0 => 'request.url',
            1 => 'request.path',
            2 => 'request.root',
            3 => 'request.input',
            4 => 'request.full_url',
            5 => 'request.segments',
            6 => 'request.uri',
            7 => 'request.query',
            8 => 'request.parsed.scheme',
            9 => 'request.parsed.host',
            10 => 'request.parsed.domain.0',
            11 => 'url.previous',
            12 => 'user',
        ], array_keys(Arr::dot(Parser::data())));
    }
}
