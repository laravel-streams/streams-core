<?php

namespace Streams\Core\Tests\Support\Macros;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Includes;

class FactoryIncludeTest extends CoreTestCase
{
    public function test_it_registers_view_includes()
    {
        View::include('slot', 'welcome');

        $this->assertTrue(Includes::get('slot')->contains('welcome'));
    }
}
