<?php

namespace Streams\Core\Tests\Support\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Streams\Core\Tests\CoreTestCase;

class ArrParseTest extends CoreTestCase
{
    public function test_it_parses_array_values()
    {
        $array = Arr::parse(['path' => '{request.url}']);

        $this->assertSame(['path' => URL::to('')], $array);
    }

    public function test_it_parses_recursively()
    {
        $array = Arr::parse(['params' => ['path' => '{request.url}']]);

        $this->assertSame(['params' => ['path' => URL::to('')]], $array);
    }
}
