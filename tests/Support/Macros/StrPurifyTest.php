<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;

class StrPurifyTest extends CoreTestCase
{

    public function test_it_purifies_strings()
    {
        $this->assertSame('foo bar', Str::purify('foo bar'));
    }
}
