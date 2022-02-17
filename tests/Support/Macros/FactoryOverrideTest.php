<?php

namespace Streams\Core\Tests\Support\Traits;

use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\View;

class FactoryOverrideTest extends CoreTestCase
{
    public function test_it_overrides_views()
    {
        View::override('welcome', 'resources/views/testing.blade.php');

        $content = (string) View::make('welcome');

        $this->assertStringContainsString('Testing', $content);
    }
}
