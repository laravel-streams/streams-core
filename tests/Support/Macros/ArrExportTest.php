<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Core\Tests\CoreTestCase;

class ArrExportTest extends CoreTestCase
{
    public function test_it_exports_arrays()
    {
        $this->assertEquals("[
    'foo' => 'bar',
]", Arr::export(['foo' => 'bar']));
    }
}
