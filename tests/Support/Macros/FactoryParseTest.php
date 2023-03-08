<?php

namespace Streams\Core\Tests\Support\Macros;

use Illuminate\View\View;
use Illuminate\Support\Facades\File;
use Streams\Core\Tests\CoreTestCase;
use Illuminate\Support\Facades\View as ViewFacade;

class FactoryParseTest extends CoreTestCase
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
        $view = ViewFacade::parse('Hi {{ $name }}', [
            'name' => 'Ryan',
        ]);

        $this->assertInstanceOf(View::class, $view);

        $this->assertSame('Hi Ryan', $view->render());
    }
}
