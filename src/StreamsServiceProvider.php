<?php namespace Anomaly\Streams\Platform;

use Illuminate\Support\ServiceProvider;

/**
 * Class StreamsServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform
 */
class StreamsServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPackages();
        $this->registerCore();
    }

    /**
     * Register packages.
     */
    protected function registerPackages()
    {
        $this->app->register('TwigBridge\ServiceProvider');
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Illuminate\Html\HtmlServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
    }

    /**
     * Register core.
     */
    protected function registerCore()
    {
        // Register the base application.
        $this->app->register('Anomaly\Streams\Platform\Application\ApplicationServiceProvider');

        // Register the asset and image services.
        $this->app->register('Anomaly\Streams\Platform\Asset\AssetServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Image\ImageServiceProvider');

        // Register the streams services.
        $this->app->register('Anomaly\Streams\Platform\Entry\EntryServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Field\FieldServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Stream\StreamServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Assignment\AssignmentServiceProvider');

        // Register UI services.
        $this->app->register('Anomaly\Streams\Platform\Ui\UiServiceProvider');

        // Register addon services.
        $this->app->register('Anomaly\Streams\Platform\Addon\AddonServiceProvider');
    }
}
