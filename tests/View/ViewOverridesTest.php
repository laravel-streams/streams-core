<?php

namespace Streams\Core\Tests\Stream\View;

use Illuminate\Support\Facades\View;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Overrides;

class ViewOverridesTest extends CoreTestCase
{

    public function test_it_registers_view_overrides()
    {
        Overrides::put('welcome', 'resources/views/testing.blade.php');

        $this->assertTrue(Overrides::has('welcome'));
    }

    public function test_it_overrides_views()
    {
        Overrides::put('welcome', 'resources/views/testing.blade.php');

        $content = (string) View::make('welcome');

        $this->assertStringContainsString('Testing', $content);
    }
}
