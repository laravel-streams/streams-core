<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Str;
use Streams\Core\Tests\CoreTestCase;

class StrHumanizeTest extends CoreTestCase
{

    public function test_it_humanizes_strings()
    {
        $this->assertSame('foo bar', Str::humanize('foo_bar'));
        $this->assertSame('foo bar', Str::humanize('foo-bar', '-'));
    }
}
