<?php

namespace Streams\Core\Tests\Support\Traits;

use Tests\TestCase;
use Streams\Core\View\ViewTemplate;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class FactoryMacrosTest extends TestCase
{

    public function tearDown(): void
    {
        $templates = storage_path('streams/default/templates');

        if (is_dir($templates)) {
            File::deleteDirectory($templates);
        }
    }

    public function test_can_register_view_includes()
    {
        $path = ViewTemplate::path('Hi {{ $name }}');

        View::include('slot', $path);

        $this->assertSame('Hi Ryan', View::includes('slot', [
            'name' => 'Ryan',
        ]));
    }
}
