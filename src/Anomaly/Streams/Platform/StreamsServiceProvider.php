<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Asset\Image;
use Composer\Autoload\ClassLoader;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\DefaultCommandBus;

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
        $this->app->resolving(
            'Laracasts\Commander\DefaultCommandBus',
            function (DefaultCommandBus $commandBus) {
                $commandBus->decorate('Anomaly\Streams\Platform\Commander\CommandValidator');
            }
        );

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

        // Put some of this stuff elsewhere / in a method
        $this->app['streams.path']       = dirname(dirname(dirname(dirname(__DIR__))));
        $this->app['streams.asset.path'] = public_path('assets/' . app('streams.application')->getReference());

        app('config')->addNamespace(
            'streams',
            $this->app['streams.path'] . '/resources/config'
        );


        $this->bindings();


        $this->app->singleton(
            'streams.asset',
            function () {

                return new Asset(new Filesystem(), app('streams.application'));
            }
        );
        $this->app->singleton(
            'streams.image',
            function () {

                return new Image();
            }
        );
        $this->app['streams.asset']->addNamespace(
            'asset',
            public_path('assets/' . app('streams.application')->getReference())
        );
        $this->app['streams.asset']->addNamespace('streams', $this->app['streams.path'] . '/resources');


        $loader = new ClassLoader();
        $loader->addPsr4(
            'Anomaly\Streams\Platform\Model\\',
            base_path('storage/models/streams/' . app('streams.application')->getReference())
        );
        $loader->register();


        $this->app['config']->set('view.paths', [$this->app['streams.path'] . '/resources/views']);
        $this->app['view']->addNamespace('streams', $this->app['streams.path'] . '/resources/views');
        $this->app['view']->composer('*', 'Anomaly\Streams\Platform\View\Composer');


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
            'streams.boot',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener@whenStreamsIsBooting'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Extension\ExtensionListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\FieldType\FieldTypeListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Block\BlockListener'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Tag\TagListener'
        );
        $this->app['events']->listen(
            'streams.boot',
            '\Anomaly\Streams\Platform\Addon\Theme\ThemeListener@whenStreamsIsBooting'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Theme\ThemeListener'
        );
        $this->app['events']->listen(
            'streams.boot',
            '\Anomaly\Streams\Platform\Addon\Module\ModuleListener@whenStreamsIsBooting'
        );
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );
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

    protected function bindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams::config.streams.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams::config.streams.repository')
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            config('streams::config.fields.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            config('streams::config.fields.repository')
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            config('streams::config.assignments.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            config('streams::config.assignments.repository')
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            config('streams::config.entries.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            config('streams::config.entries.repository')
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface',
            config('streams::config.buttons.repository')
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Icon\Contract\IconRepositoryInterface',
            config('streams::config.icons.repository')
        );

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
