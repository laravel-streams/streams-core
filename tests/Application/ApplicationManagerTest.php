<?php

namespace Streams\Core\Tests\Application;

use Tests\TestCase;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Applications;

class ApplicationManagerTest extends TestCase
{

    public function testMake()
    {
        $addon = Applications::make('default');

        $this->assertInstanceOf(Application::class, $addon);
    }

    public function testHandle()
    {
        $this->assertEquals('default', Applications::handle());
    }
}
