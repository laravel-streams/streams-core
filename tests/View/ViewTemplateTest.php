<?php

namespace Streams\Core\Tests\Stream\View;

use Illuminate\View\View;
use Streams\Core\View\ViewTemplate;
use Illuminate\Support\Facades\File;
use Streams\Core\Tests\CoreTestCase;

class ViewTemplateTest extends CoreTestCase
{

    protected function tearDown(): void
    {
        $templates = storage_path('streams/default/templates');

        if (is_dir($templates)) {
            File::deleteDirectory($templates);
        }

        parent::tearDown();
    }

    public function test_it_renders_string_templates()
    {
        $view = ViewTemplate::make('Hi {{ $name }}', [
            'name' => 'Ryan',
        ]);

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame('Hi Ryan', $view->render());
    }

    public function test_it_returns_template_paths()
    {
        $path = ViewTemplate::path('Hi {{ $name }}');

        $this->assertSame('storage::templates/f92365e75fd8163c8bcd82ee0914e251', $path);
    }
}
