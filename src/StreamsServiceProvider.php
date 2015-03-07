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
        /**
         * Register all third party packages first.
         */
        $this->app->register('TwigBridge\ServiceProvider');
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Illuminate\Html\HtmlServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');

        /**
         * Register all Streams Platform services.
         */
        $this->app->register('Anomaly\Streams\Platform\Application\ApplicationServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Console\ConsoleSupportServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Exception\ExceptionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Message\MessageServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Support\SupportServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Model\EloquentServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Asset\AssetServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Image\ImageServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\View\ViewServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\UiServiceProvider');

        /**
         * Register all the Streams API services.
         */
        $this->app->register('Anomaly\Streams\Platform\Entry\EntryServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Field\FieldServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Stream\StreamServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Assignment\AssignmentServiceProvider');

        /**
         * Register all addons LAST so they have
         * access to the full gamut of services.
         */
        $this->app->register('Anomaly\Streams\Platform\Addon\AddonServiceProvider');
    }
}
