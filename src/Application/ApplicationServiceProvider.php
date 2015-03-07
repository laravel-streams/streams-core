<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Command\AddMarkdownExtension;
use Anomaly\Streams\Platform\Application\Command\AddTwigExtensions;
use Anomaly\Streams\Platform\Application\Command\CheckDirectoryPermissions;
use Anomaly\Streams\Platform\Application\Command\ConfigureCommandBus;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Anomaly\Streams\Platform\Application\Command\LoadStreamsConfiguration;
use Anomaly\Streams\Platform\Application\Command\SetCoreConnection;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;
use Robbo\Presenter\Decorator;

/**
 * Class ApplicationServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application
 */
class ApplicationServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new SetCoreConnection());
        $this->dispatch(new ConfigureCommandBus());
        $this->dispatch(new LoadStreamsConfiguration());
        $this->dispatch(new ConfigureTranslator());
        $this->dispatch(new AddTwigExtensions());

        // Ready!
        $this->dispatch(new InitializeApplication());
        $this->dispatch(new CheckDirectoryPermissions());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Application\Application',
            'Anomaly\Streams\Platform\Application\Application'
        );

        $this->app->singleton(
            'Michelf\Markdown',
            'Michelf\Markdown'
        );

        $this->app->singleton(
            'Robbo\Presenter\Decorator',
            'Robbo\Presenter\Decorator'
        );

        $this->app->bind(
            'path.lang',
            function () {
                return realpath(__DIR__ . '/../../resources/lang');
            }
        );
    }
}
