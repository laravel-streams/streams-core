<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\View;

class FactoryIncludesTest extends CoreTestCase
{
    public function test_it_renders_view_includes()
    {
        View::include('slot', 'welcome');

        $this->assertStringContainsString('Welcome', View::includes('slot'));
    }
}
