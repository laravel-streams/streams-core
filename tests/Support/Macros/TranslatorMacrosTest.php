<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Illuminate\Support\Str;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

class TranslatorMacrosTest extends TestCase
{

    public function test_can_translate_strings()
    {
        $this->assertSame('Example', Lang::translate('streams::testing.example'));
    }

    public function test_can_translate_arrays()
    {
        $this->assertSame(['example' => 'Example'], Lang::translate([
            'example' => 'streams::testing.example',
        ]));
    }
}
