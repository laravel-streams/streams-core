<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Command\AddMarkdownExtension;
use Anomaly\Streams\Platform\Application\Command\AddTwigBridgeExtensions;
use Anomaly\Streams\Platform\Application\Command\CheckDirectoryPermissions;
use Anomaly\Streams\Platform\Application\Command\ConfigureCommandBus;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\LoadStreamsConfiguration;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

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
        $this->dispatch(new ConfigureCommandBus());
        $this->dispatch(new LoadStreamsConfiguration());
        $this->dispatch(new AddTwigBridgeExtensions());
        $this->dispatch(new AddMarkdownExtension());
        $this->dispatch(new ConfigureTranslator());

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
    }
}
