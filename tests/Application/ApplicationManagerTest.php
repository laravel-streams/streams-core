<?php

namespace Streams\Core\Tests\Application;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Applications;

class ApplicationManagerTest extends CoreTestCase
{

    public function test_it_returns_a_default_application()
    {
        $addon = Applications::make('default');

        $this->assertInstanceOf(Application::class, $addon);
    }

    public function test_it_returns_the_active_application()
    {
        $this->assertInstanceOf(Application::class, Applications::active());

        $this->assertEquals('default', Applications::active()->id);
    }

    public function test_it_can_activate_an_addon()
    {
        $addon = new Application([
            'stream' => Streams::make('applications'),
            'id' => 'new',
            'match' => '*',
        ]);

        Applications::activate($addon);

        $this->assertInstanceOf(Application::class, Applications::active());

        $this->assertEquals('new', Applications::active()->id);
    }
}
