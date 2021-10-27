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

    public function testActive()
    {
        $addon = new Application([
            'id' => 'new',
            'match' => '*',
        ]);

        $this->assertEquals('default', Applications::active()->id);

        Applications::activate($addon);

        $this->assertEquals('new', Applications::active()->id);
    }
}
