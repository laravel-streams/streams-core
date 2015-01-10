<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Command\LocateApplicationCommand;
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
        $this->setCommandBusMapper();

        $this->dispatch(new LocateApplicationCommand());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplication();
        $this->registerListeners();
        $this->configurePackages();
    }

    /**
     * Register the application.
     */
    protected function registerApplication()
    {
        $this->app->instance('streams.path', $this->app->make('path.base') . '/vendor/anomaly/streams-platform');

        $this->app->singleton(
            'Anomaly\Streams\Platform\Application\Application',
            'Anomaly\Streams\Platform\Application\Application'
        );

        $this->app->make('config')->set(
            'streams::config',
            $this->app->make('files')->getRequire(__DIR__ . '/../../resources/config/config.php')
        );

        $this->app->make('view')->addNamespace('streams', $this->app['streams.path'] . '/resources/views');
    }

    /**
     * Register the application listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Application\Listener\ApplicationBootingListener'
        );
    }

    /**
     * Manually configure 3rd party packages.
     */
    protected function configurePackages()
    {
        // Configure Translatable
        $this->app->make('config')->set('translatable::locales', ['en', 'es']);
        $this->app->make('config')->set('translatable::translation_suffix', 'Translation');

        // Bind a string loader version of twig.
        $this->app->bind(
            'twig.string',
            function () {
                $twig = clone(app('twig'));

                $twig->setLoader(new \Twig_Loader_String());

                return $twig;
            }
        );
    }

    /**
     * Use a custom mapper for commands.
     */
    protected function setCommandBusMapper()
    {
        // Set the default command mapper.
        $this->app->make('Illuminate\Bus\Dispatcher')->mapUsing(
            function ($command) {
                return get_class($command) . 'Handler@handle';
            }
        );
    }
}
