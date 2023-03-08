<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;

class StrTruncateTest extends CoreTestCase
{
    public function test_it_truncates_strings()
    {
        $this->assertSame('Test...', Str::truncate('Test me!', 4));
        $this->assertSame('Test me!', Str::truncate('Test me!', 10));
    }
}
