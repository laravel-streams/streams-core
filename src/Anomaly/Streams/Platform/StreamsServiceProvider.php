<?php namespace Anomaly\Streams\Platform;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\DefaultCommandBus;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class StreamsServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
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
        $this->app->resolving(
            'Laracasts\Commander\DefaultCommandBus',
            function (DefaultCommandBus $commandBus) {
                $commandBus->decorate('Anomaly\Streams\Platform\Commander\CommandValidator');
            }
        );

        $this->configurePackages();

        $this->registerPackages();
        $this->registerCore();
    }

    /**
     * Register package service providers.
     */
    protected function registerPackages()
    {
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Illuminate\Html\HtmlServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Anomaly\Lexicon\LexiconServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Way\Generators\GeneratorsServiceProvider');
        $this->app->register('Laracasts\Commander\CommanderServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');
    }

    /**
     * Register core service providers.
     */
    protected function registerCore()
    {
        // Register the base application.
        $this->app->register('Anomaly\Streams\Platform\Application\ApplicationServiceProvider');

        // Register the asset and image services.
        $this->app->register('Anomaly\Streams\Platform\Asset\AssetServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Image\ImageServiceProvider');

        // Register the streams utilities.
        $this->app->register('Anomaly\Streams\Platform\Entry\EntryServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Field\FieldServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Stream\StreamServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Assignment\AssignmentServiceProvider');

        // Register UI utilities.
        $this->app->register('Anomaly\Streams\Platform\Ui\Form\FormServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Ui\Table\TableServiceProvider');

        $this->bindings();

        $this->app['streams.asset']->addNamespace(
            'asset',
            public_path('assets/' . app('streams.application')->getReference())
        );
        $this->app['streams.asset']->addNamespace('streams', $this->app['streams.path'] . '/resources');

        $this->app['view']->composer('*', 'Anomaly\Streams\Platform\View\Composer');

        $this->app->register('Anomaly\Streams\Platform\Provider\AddonServiceProvider');
    }

    protected function configurePackages()
    {
        // Configure Translatable
        $this->app['config']->set('translatable::locales', ['en', 'es']);
        $this->app['config']->set('translatable::translation_suffix', 'Translation');
    }

    protected function bindings()
    {

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
            config('streams::config.modules.model')
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface',
            config('streams::config.modules.repository')
        );
    }
}
