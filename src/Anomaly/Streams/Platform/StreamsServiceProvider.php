<?php namespace Anomaly\Streams\Platform;

use Illuminate\Support\ServiceProvider;

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
     * Everything has booted.
     */
    public function boot()
    {
        $this->app->bind(
            'path.lang',
            function () {
                return __DIR__ . '/../../../../resources/lang';
            }
        );

        $this->app->make('events')->fire('streams.boot');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // TODO: This should be improved as well.
        if (app('request')->path() !== 'installer' && !file_exists(base_path('config/database.php'))) {

            app('router')->any(
                '{all}',
                function () {
                    return redirect(url('installer'));
                }
            )->where('all', '.*');

            return;
        }

        $this->checkEnvironment();
        $this->configurePackages();
        $this->registerListeners();

        $this->registerPackageAliases();
        $this->registerPackages();
        $this->registerCore();
    }

    /**
     * Register package aliases.
     */
    protected function registerPackageAliases()
    {
        // We'll leave core aliases in tact though they are not used in core.
        // People will expect these to be available based on past experience.

        // Be warned these will likely be making their exit in future
        // releases of the Laravel framework. They are a somewhat
        // poor practice in pattern so let's just ignore them..
        $this->app->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        $this->app->alias('Agent', 'Jenssegers\Agent\Facades\Agent');

        $this->app->alias('Form', 'Illuminate\Html\FormFacade');
        $this->app->alias('HTML', 'Illuminate\Html\HtmlFacade');
    }

    /**
     * Register package service providers.
     */
    protected function registerPackages()
    {
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Anomaly\Lexicon\LexiconServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Way\Generators\GeneratorsServiceProvider');
        $this->app->register('Laracasts\Commander\CommanderServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');
    }

    /**
     * Register core service providers.
     */
    protected function registerCore()
    {
        $this->app->register('Anomaly\Streams\Platform\Provider\ApplicationServiceProvider');

        $this->app->register('Anomaly\Streams\Platform\Provider\ServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ExceptionServiceProvider');

        // TODO: Put some of this stuff elsewhere / in a method
        $this->app['streams.path']       = dirname(dirname(dirname(dirname(__DIR__))));
        $this->app['streams.asset.path'] = public_path('assets/' . app('streams.application')->getReference());

        $this->app->register('Anomaly\Streams\Platform\Provider\AssetServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ModelServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ViewServiceProvider');

        // Register addon components.
        $this->app->register('Anomaly\Streams\Platform\Provider\AddonServiceProvider');
    }

    protected function checkEnvironment()
    {
        $directories = [
            'public/assets',
            'storage/framework',
        ];

        if (config('app.debug')) {
            foreach ($directories as $directory) {
                if (!is_dir($directory)) {
                    mkdir($directory, 0777, true);
                } else {
                    chmod(base_path($directory), 0777);
                }
            }
        }
    }

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.Module.Event.*',
            'Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Stream.Event.*',
            'Anomaly\Streams\Platform\Stream\StreamListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Assignment.Event.*',
            'Anomaly\Streams\Platform\Assignment\AssignmentListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Ui.Form.Event.*',
            'Anomaly\Streams\Platform\Ui\Form\FormListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Ui.Table.Event.*',
            'Anomaly\Streams\Platform\Ui\Table\TableListener'
        );
    }

    protected function configurePackages()
    {
        // Configure Translatable
        $this->app['config']->set('translatable::locales', ['en', 'es']);
        $this->app['config']->set('translatable::translation_suffix', 'Translation');
    }
}
