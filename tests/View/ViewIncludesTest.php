<?php

namespace Streams\Core\Tests\Stream\View;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Includes;

class ViewIncludesTest extends CoreTestCase
{
    public function test_it_registers_view_includes()
    {
        Includes::include('slot', 'welcome.blade.php');

        $this->assertTrue(Includes::get('slot')->contains('welcome.blade.php'));
    }

    public function test_it_overrides_included_views()
    {
        Includes::include('slot', 'welcome.blade.php');

        $this->assertSame('welcome.blade.php', Includes::get('slot')->get('welcome.blade.php'));

        Includes::slot('slot')->put('welcome.blade.php', 'alternate.blade.php');

        $this->assertSame('alternate.blade.php', Includes::get('slot')->get('welcome.blade.php'));
    }
}
