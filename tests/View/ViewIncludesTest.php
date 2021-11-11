<?php

namespace Streams\Core\Tests\Stream\View;

use Tests\TestCase;
use Streams\Core\Support\Facades\Includes;

class ViewIncludesTest extends TestCase
{

    public function test_can_register_view_includes()
    {
        Includes::include('slot', 'welcome.blade.php');

        $this->assertTrue(Includes::get('slot')->contains('welcome.blade.php'));
    }

    public function test_can_override_an_included_view()
    {
        Includes::include('slot', 'welcome.blade.php');

        $this->assertSame('welcome.blade.php', Includes::get('slot')->get('welcome.blade.php'));

        Includes::slot('slot')->put('welcome.blade.php', 'alternate.blade.php');

        $this->assertSame('alternate.blade.php', Includes::get('slot')->get('welcome.blade.php'));
    }
}
