<?php

namespace Streams\Core\Tests\Stream\View;

use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Tests\TestCase;
use Streams\Core\View\ViewTemplate;

class ViewTemplateTest extends TestCase
{

    public function tearDown(): void
    {
        $templates = storage_path('streams/default/templates');

        if (is_dir($templates)) {
            File::deleteDirectory($templates);
        }
    }

    public function test_can_render_string_templates()
    {
        $view = ViewTemplate::make('Hi {{ $name }}', [
            'name' => 'Ryan',
        ]);

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame('Hi Ryan', $view->render());
    }

    public function test_can_return_view_paths()
    {
        $path = ViewTemplate::path('Hi {{ $name }}');

        $this->assertSame('storage::templates.f92365e75fd8163c8bcd82ee0914e251', $path);
    }
}
