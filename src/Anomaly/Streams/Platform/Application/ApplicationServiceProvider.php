<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Event\ApplicationIsBooting;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\DefaultCommandBus;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class ApplicationServiceProvider extends ServiceProvider
{
    use EventGenerator;
    use DispatchableTrait;

    public function boot()
    {
        $this->raise(new ApplicationIsBooting());

        $this->dispatchEventsFor($this);
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

    protected function registerApplication()
    {
        $this->app->instance('streams.application', app('Anomaly\Streams\Platform\Application\Application'));

        $this->app['streams.path'] = base_path('vendor/anomaly/streams-platform');

        $this->app['config']->addNamespace('streams', $this->app['streams.path'] . '/resources/config');

        $this->app['view']->addNamespace('streams', $this->app['streams.path'] . '/resources/views');

        if (file_exists(base_path('config/distribution.php'))) {

            app('streams.application')->locate();

            if (file_exists(base_path('config/database.php'))) {

                app('streams.application')->setup();
            }
        }
    }

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Application.Event.*',
            'Anomaly\Streams\Platform\Application\ApplicationListener'
        );
    }

    protected function configurePackages()
    {
        // Configure Translatable
        $this->app['config']->set('translatable::locales', ['en', 'es']);
        $this->app['config']->set('translatable::translation_suffix', 'Translation');

        // Auto-decorate commands with validators.
        $this->app->resolving(
            'Laracasts\Commander\DefaultCommandBus',
            function (DefaultCommandBus $commandBus) {
                $commandBus->decorate('Anomaly\Streams\Platform\Commander\CommandValidator');
            }
        );
    }
}
