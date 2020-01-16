<?php

use Anomaly\Streams\Platform\Support\Template;
use Anomaly\Streams\Platform\Application\Application;

class TemplateTest extends TestCase
{

    public function testCanRenderStringTemplate()
    {
        $this->assertEquals('test: 50', Template::render('{{ $label }}: {{ 10*5 }}', ['label' => 'test']));
    }

    public function testCanGenerateBladeTemplate()
    {
        app('files')->deleteDirectory(app(Application::class)->getStoragePath() . '/support/parsed');

        $this->assertEquals(
            'storage::' . str_replace(application()->getStoragePath(), '', 'support/parsed/d2525f04576e7a79442569e5f3cc6e8e'),
            Template::make('{{ $label }}: {{ 10*5 }}')
        );
    }

    public function testCanGenerateTemplateStoragePath()
    {
        app('files')->deleteDirectory(app(Application::class)->getStoragePath() . '/support/parsed');

        $this->assertEquals(
            app(Application::class)->getStoragePath() . '/support/parsed/d2525f04576e7a79442569e5f3cc6e8e',
            Template::path('{{ $label }}: {{ 10*5 }}')
        );
    }
}
