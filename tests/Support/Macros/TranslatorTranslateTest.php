<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\Support\Facades\Lang;
use Streams\Core\Tests\CoreTestCase;

class TranslatorTranslateTest extends CoreTestCase
{
    public function test_it_translates_strings()
    {
        $this->assertSame('Foo Bar', Lang::translate('testing.foo_bar'));
    }

    public function test_it_translates_arrays()
    {
        $this->assertSame(['foo_bar' => 'Foo Bar'], Lang::translate([
            'foo_bar' => 'testing.foo_bar',
        ]));
    }
}
