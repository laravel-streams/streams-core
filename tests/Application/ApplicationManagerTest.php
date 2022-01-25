<?php

namespace Streams\Core\Tests\Application;

use Tests\TestCase;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Applications;

class ApplicationManagerTest extends TestCase
{

    public function testCanReturnDefaultApplicationInstance()
    {
        $addon = Applications::make('default');

        $this->assertInstanceOf(Application::class, $addon);
    }

    public function testActivatesDefaultApplication()
    {
        $this->assertEquals('default', Applications::active()->id);
    }

    public function testCanActivateApplication()
    {
        $addon = new Application([
            'stream' => Streams::make('core.applications'),
            'id' => 'new',
            'match' => '*',
        ]);

        Applications::activate($addon);

        $this->assertEquals('new', Applications::active()->id);
    }
}
