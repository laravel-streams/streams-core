<?php

namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Addon\Theme\Command\LoadCurrentTheme;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\SetApplicationDomain;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\AssignmentObserver;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Event\Booted;
use Anomaly\Streams\Platform\Event\Booting;
use Anomaly\Streams\Platform\Event\Ready;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Field\FieldObserver;
use Anomaly\Streams\Platform\Http\Routing\Matching\CaseInsensitiveUriValidator;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Stream\StreamObserver;
use Anomaly\Streams\Platform\Support\Configurator;
use Anomaly\Streams\Platform\View\Cache\CacheAdapter;
use Anomaly\Streams\Platform\View\Cache\CacheKey;
use Anomaly\Streams\Platform\View\Cache\CacheStrategy;
use Anomaly\Streams\Platform\View\Command\AddViewNamespaces;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Anomaly\Streams\Platform\View\ViewServiceProvider;
use Asm89\Twig\CacheExtension\Extension;
use Composer\Autoload\ClassLoader;
use Illuminate\Cache\Repository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Application as Laravel;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * Class StreamsServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsServiceProvider extends ServiceProvider
{

    /**
     * The app instance.
     *
     * @var Laravel
     */
    protected $app;

    /**
     * The scheduled commands.
     *
     * @var array
     */
    protected $schedule = [];

    /**
     * The providers to register.
     *
     * @var array
     */
    protected $providers = [
        ViewServiceProvider::class,
        StreamsEventProvider::class,
        StreamsConsoleProvider::class,
    ];

    /**
     * The plugins to register.
     *
     * @var array
     */
    protected $plugins = [
        StreamsPlugin::class,
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        'Illuminate\Routing\UrlGenerator'                                                => 'Anomaly\Streams\Platform\Routing\UrlGenerator',
        'Illuminate\Contracts\Routing\UrlGenerator'                                      => 'Anomaly\Streams\Platform\Routing\UrlGenerator',
        'Illuminate\Database\Migrations\MigrationRepositoryInterface'                    => 'Anomaly\Streams\Platform\Database\Migration\MigrationRepository',
        'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface'               => 'Anomaly\Streams\Platform\Entry\EntryRepository',
        'Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface'               => 'Anomaly\Streams\Platform\Field\FieldRepository',
        'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface'             => 'Anomaly\Streams\Platform\Stream\StreamRepository',
        'Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface'            => 'Anomaly\Streams\Platform\Model\EloquentRepository',
        'Anomaly\Streams\Platform\Version\Contract\VersionRepositoryInterface'           => 'Anomaly\Streams\Platform\Version\VersionRepository',
        'Anomaly\Streams\Platform\Lock\Contract\LockRepositoryInterface'                 => 'Anomaly\Streams\Platform\Lock\LockRepository',
        'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface'     => 'Anomaly\Streams\Platform\Assignment\AssignmentRepository',
        'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface'       => 'Anomaly\Streams\Platform\Addon\Module\ModuleRepository',
        'Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface' => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionRepository',
        'addon.collection'                                                               => 'Anomaly\Streams\Platform\Addon\AddonCollection',
        'module.collection'                                                              => 'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
        'extension.collection'                                                           => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
        'field_type.collection'                                                          => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',
        'plugin.collection'                                                              => 'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
        'theme.collection'                                                               => 'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection',
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        'asset'    => \Anomaly\Streams\Platform\Asset\Asset::class,
        'messages' => \Anomaly\Streams\Platform\Message\MessageBag::class,

        \Anomaly\Streams\Platform\Asset\Asset::class             => \Anomaly\Streams\Platform\Asset\Asset::class,
        \Anomaly\Streams\Platform\Message\MessageBag::class      => \Anomaly\Streams\Platform\Message\MessageBag::class,
        \Anomaly\Streams\Platform\Application\Application::class => \Anomaly\Streams\Platform\Application\Application::class,

        'Illuminate\Database\Migrations\Migrator'   => 'Anomaly\Streams\Platform\Database\Migration\Migrator',
        'Illuminate\Contracts\Routing\UrlGenerator' => 'Anomaly\Streams\Platform\Routing\UrlGenerator',

        'Illuminate\Database\Seeder' => 'Anomaly\Streams\Platform\Database\Seeder\Seeder',

        'Anomaly\Streams\Platform\Stream\StreamStore' => 'Anomaly\Streams\Platform\Stream\StreamStore',

        'Anomaly\Streams\Platform\Addon\AddonCollection'                                     => 'Anomaly\Streams\Platform\Addon\AddonCollection',
        'Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection'                        => 'Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection',
        'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection'       => 'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection',
        'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection' => 'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Navigation\NavigationCollection',

        'Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection' => 'Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection',

        'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'         => 'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection',
        'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection'       => 'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
        'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'       => 'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
        'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection' => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
        'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection' => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',

        'Anomaly\Streams\Platform\Asset\Asset'      => 'Anomaly\Streams\Platform\Asset\Asset',
        'Anomaly\Streams\Platform\Asset\AssetPaths' => 'Anomaly\Streams\Platform\Asset\AssetPaths',

        'Anomaly\Streams\Platform\Support\Authorizer' => 'Anomaly\Streams\Platform\Support\Authorizer',
        'Anomaly\Streams\Platform\Support\Parser'     => 'Anomaly\Streams\Platform\Support\Parser',

        //'Anomaly\Streams\Platform\Support\Currency'                                          => 'Anomaly\Streams\Platform\Support\Currency',
        //'Anomaly\Streams\Platform\Support\Hydrator'                                          => 'Anomaly\Streams\Platform\Support\Hydrator',
        //'Anomaly\Streams\Platform\Support\Resolver'                                          => 'Anomaly\Streams\Platform\Support\Resolver',
        //'Anomaly\Streams\Platform\Support\Translator'                                        => 'Anomaly\Streams\Platform\Support\Translator',
        //'Anomaly\Streams\Platform\Asset\AssetParser'                                         => 'Anomaly\Streams\Platform\Asset\AssetParser',
        //'Anomaly\Streams\Platform\Asset\AssetFilters'                                        => 'Anomaly\Streams\Platform\Asset\AssetFilters',

        'Anomaly\Streams\Platform\Image\Image'       => 'Anomaly\Streams\Platform\Image\Image',
        'Anomaly\Streams\Platform\Image\ImagePaths'  => 'Anomaly\Streams\Platform\Image\ImagePaths',
        'Anomaly\Streams\Platform\Image\ImageMacros' => 'Anomaly\Streams\Platform\Image\ImageMacros',

        'Anomaly\Streams\Platform\Ui\Icon\IconRegistry'                     => 'Anomaly\Streams\Platform\Ui\Icon\IconRegistry',
        'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry'                 => 'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry',
        'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry'     => 'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry',
        'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry' => 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry',

        'Anomaly\Streams\Platform\View\ViewComposer'        => 'Anomaly\Streams\Platform\View\ViewComposer',
        'Anomaly\Streams\Platform\View\ViewTemplate'        => 'Anomaly\Streams\Platform\View\ViewTemplate',
        'Anomaly\Streams\Platform\View\ViewIncludes'        => 'Anomaly\Streams\Platform\View\ViewIncludes',
        'Anomaly\Streams\Platform\View\ViewOverrides'       => 'Anomaly\Streams\Platform\View\ViewOverrides',
        'Anomaly\Streams\Platform\View\ViewMobileOverrides' => 'Anomaly\Streams\Platform\View\ViewMobileOverrides',

        //'Anomaly\Streams\Platform\Support\Template'               => 'Anomaly\Streams\Platform\Support\Template',
        'Anomaly\Streams\Platform\Support\Purifier'         => 'Anomaly\Streams\Platform\Support\Purifier',
        'Anomaly\Streams\Platform\Field\FieldRouter'        => 'Anomaly\Streams\Platform\Field\FieldRouter',
    ];

    /**
     * Boot the service provider.
     */
    public function boot()
    {

        event(new Booting());

        // Take care of core utilities.
        $this->setCoreConnection();
        $this->configureUriValidator();
        $this->initializeApplication();

        // Load application specific .env file.
        $this->loadEnvironmentOverrides();

        // Setup and preparing utilities.
        $this->loadStreamsConfiguration();
        $this->configureFileCacheStore();
        dispatch_now(new ConfigureTranslator()); // @todo revisit
        $this->autoloadEntryModels();
        $this->addAssetNamespaces();
        $this->addImageNamespaces();
        $this->configureRequest();

        // Observe our base models.
        EntryModel::observe(EntryObserver::class);
        FieldModel::observe(FieldObserver::class);
        StreamModel::observe(StreamObserver::class);
        EloquentModel::observe(EloquentObserver::class);
        AssignmentModel::observe(AssignmentObserver::class);

        /**
         * Boot event is used to help scheduler
         * and artisan command registering.
         */
        $this->app->booted(
            function () {

                event(new Booted());

                /* @var Schedule $schedule */
                $schedule = app(Schedule::class);

                /**
                 * @todo move this kind of logic to the app service providers
                 */
                foreach (array_merge($this->schedule, config('streams.schedules', [])) as $frequency => $commands) {
                    foreach (array_filter($commands) as $command) {
                        if (str_contains($frequency, ' ')) {
                            $schedule->command($command)->cron($frequency);
                        }

                        if (!str_contains($frequency, ' ')) {
                            $schedule->command($command)->{camel_case($frequency)}();
                        }
                    }
                }

                /* @var AddonManager $manager */
                $manager = app(AddonManager::class);

                $manager->register();

                /* @var Dispatcher $events */
                $events = app(Dispatcher::class);

                $events->listen(
                    RegisteringTwigPlugins::class,
                    function (RegisteringTwigPlugins $event) {
                        $twig = $event->getTwig();

                        foreach ($this->plugins as $plugin) {
                            if (!$twig->hasExtension($plugin)) {
                                $twig->addExtension($this->app->make($plugin));
                            }
                        }

                        $twig->addExtension(
                            new Extension(
                                new CacheStrategy(
                                    new CacheAdapter($this->app->make(Repository::class)),
                                    new CacheKey()
                                )
                            )
                        );
                    }
                );

                /*
                 * Do this after addons are registered
                 * so that they can override named routes.
                 */
                dispatch_now(new LoadCurrentTheme());
                dispatch_now(new AddViewNamespaces());
                dispatch_now(new SetApplicationDomain());

                event(new Ready());
            }
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        /**
         * When config is cached by Laravel we
         * end up oddly not loading .env data.
         */
        if (is_file(base_path('bootstrap/cache/config.php')) && is_file($file = base_path('.env'))) {
            foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {

                // Check for # comments.
                if (!starts_with($line, '#')) {
                    putenv($line);
                }
            }
        }

        /*
         * Register all third party packages first.
         */
        app()->register(\Laravel\Scout\ScoutServiceProvider::class);
        app()->register(\Barryvdh\HttpCache\ServiceProvider::class);
        app()->register(\Collective\Html\HtmlServiceProvider::class);
        app()->register(\Intervention\Image\ImageServiceProvider::class);

        foreach (config('streams.listeners', []) as $event => $listeners) {
            foreach ($listeners as $key => $listener) {
                if (is_integer($listener)) {
                    $priority = $listener;
                    $listener = $key;
                } else {
                    $priority = 0;
                }

                app('events')->listen($event, $listener, $priority);
            }
        }

        // Register bindings.
        foreach (array_merge($this->bindings, config('streams.bindings', [])) as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        // Register singletons.
        foreach (array_merge($this->singletons, config('streams.singletons', [])) as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        // Register streams other providers.
        foreach (array_merge($this->providers, config('streams.providers', [])) as $provider) {
            $this->app->register($provider);
        }

        /*
         * Change the default language path so
         * that there MUST be a prefix hint.w
         */
        $this->app->singleton(
            'path.lang',
            function () {
                return realpath(__DIR__ . '/../resources/lang');
            }
        );

        /*
         * Register the path to the streams platform.
         * This is handy for helping load other streams things.
         */
        $this->app->instance(
            'streams.path',
            app('path.base') . '/vendor/anomaly/streams-platform'
        );

        /*
         * If we don't have an .env file we need to head
         * to the installer (unless that's where we're at).
         */
        if (!env('INSTALLED') && app('request')->segment(1) !== 'installer') {
            app('router')->any(
                '{url?}',
                function (Redirector $redirector) {
                    return $redirector->to('installer');
                }
            )->where(['url' => '(.*)']);

            return;
        }

        /**
         * Cache a couple files we may use heavily.
         */
        $this->app->singleton(
            'composer.json',
            function () {
                return json_decode(file_get_contents(base_path('composer.json')), true);
            }
        );

        $this->app->singleton(
            'composer.lock',
            function () {
                return json_decode(file_get_contents(base_path('composer.lock')), true);
            }
        );

        /**
         * Correct path for Paginator.
         */
        Paginator::currentPathResolver(
            function () {
                return app(UrlGenerator::class)->current();
            }
        );

        /*
         * Register system routes.
         */
        app('router')->post(
            'form/handle/{key}',
            [
                'ttl'  => 0,
                'uses' => 'Anomaly\Streams\Platform\Http\Controller\FormController@handle',
            ]
        );

        app('router')->get(
            'entry/handle/restore/{addon}/{namespace}/{stream}/{id}',
            [
                'ttl'  => 0,
                'uses' => 'Anomaly\Streams\Platform\Http\Controller\EntryController@restore',
            ]
        );

        app('router')->get(
            'entry/handle/export/{addon}/{namespace}/{stream}',
            [
                'ttl'  => 0,
                'uses' => 'Anomaly\Streams\Platform\Http\Controller\EntryController@export',
            ]
        );

        app('router')->get(
            'locks/touch',
            [
                'ttl'  => 0,
                'uses' => 'Anomaly\Streams\Platform\Http\Controller\LocksController@touch',
            ]
        );

        app('router')->get(
            'locks/release',
            [
                'ttl'  => 0,
                'uses' => 'Anomaly\Streams\Platform\Http\Controller\LocksController@release',
            ]
        );
    }

    /**
     * Set the core database connection.
     *
     * @return void
     */
    protected function setCoreConnection()
    {
        config(
            [
                'database.connections.core' => config('database.connections.' . config('database.default')),
            ]
        );
    }

    /**
     * Configure the URI validator.
     *
     * @return void
     */
    protected function configureUriValidator()
    {
        Route::$validators = array_filter(
            array_merge(
                Route::getValidators(),
                [new CaseInsensitiveUriValidator()]
            ),
            function ($validator) {
                return get_class($validator) != UriValidator::class;
            }
        );
    }

    /**
     * Initialize the Streams application.
     */
    protected function initializeApplication()
    {
        $app = env('APPLICATION_REFERENCE', 'default');

        if (PHP_SAPI == 'cli') {
            if (!defined('IS_ADMIN')) {
                define('IS_ADMIN', false);
            }

            $app = (new ArgvInput())->getParameterOption('--app', $app);

            $this->app->bind(
                'path.public',
                function () {

                    if ($path = env('PUBLIC_PATH')) {
                        return base_path($path);
                    }

                    // Check default path.
                    if (file_exists($path = base_path('public/index.php'))) {
                        return dirname($path);
                    }

                    // Check common alternative.
                    if (file_exists($path = base_path('public_html/index.php'))) {
                        return dirname($path);
                    }

                    return base_path('public');
                }
            );
        }

        $application = application();

        /*
         * Set the reference to our default first.
         * When in a dev environment and working
         * with Artisan this the same as locating.
         */
        $application->setReference($app);

        /*
         * If the application is installed
         * then locate the application and
         * initialize.
         */
        if ($application->isInstalled()) {
            if (config('database.default')) {
                try {

                    if (PHP_SAPI != 'cli') {
                        $application->locate();
                    }

                    $application->setup();

                    if (!$application->isEnabled()) {
                        abort(503);
                    }
                } catch (\Exception $e) {
                    // Do nothing.
                }
            }

            return;
        }
    }

    /**
     * Load the environment overrides.
     *
     * @return void
     */
    protected function loadEnvironmentOverrides()
    {
        if (!is_file($file = application()->getResourcesPath('.env'))) {
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {

            // Check for # comments.
            if (!starts_with($line, '#')) {
                putenv($line);
            }
        }

        /**
         * Force the internal management to reload
         * and overload from the changes that may
         * have taken place.
         */
        $dotenv = \Dotenv\Dotenv::create(base_path());
        $dotenv->overload();
    }

    /**
     * Load the streams configuration.
     *
     * @return void
     */
    protected function loadStreamsConfiguration()
    {
        if (file_exists(base_path('bootstrap/cache/config.php'))) {
            return;
        }

        // Load package configuration.
        if (is_dir($directory = realpath(__DIR__ . '/../resources/config'))) {
            Configurator::load($directory, 'streams');
        }

        // Load application overrides.
        if (is_dir($directory = application()->getResourcesPath('streams/config'))) {
            Configurator::merge($directory, 'streams');
        }

        // Load system overrides.
        if (is_dir($directory = base_path('resources/streams/config'))) {
            Configurator::merge($directory, 'streams');
        }
    }

    /**
     * Configure the file cache store so that cache doesn't collide
     * in the event that there are multiple applications running.
     *
     * @return void
     */
    protected function configureFileCacheStore()
    {
        config(['cache.stores.file.path' => application()->getStoragePath('cache')]);
    }

    /**
     * Autoload the entry models.
     *
     * @throws \Exception
     * @return void
     */
    protected function autoloadEntryModels()
    {
        $loader = null;

        foreach (spl_autoload_functions() as $autoloader) {
            if (is_array($autoloader) && $autoloader[0] instanceof ClassLoader) {
                $loader = $autoloader[0];
            }
        }

        if (!$loader) {
            throw new \Exception("The ClassLoader could not be found.");
        }

        /**
         * If a classmap is available then that's
         * much more preferred than registering.
         */
        if (file_exists($classmap = application()->getStoragePath('models/classmap.php'))) {

            $loader->addClassMap(include $classmap);

            return;
        }

        /* @var ClassLoader $loader */
        $loader->addPsr4('Anomaly\Streams\Platform\Model\\', application()->getStoragePath('models'));

        $loader->register();
    }

    /**
     * Add the asset namespace hints.
     */
    protected function addAssetNamespaces()
    {
        $asset = app(Asset::class);

        $asset->setDirectory(public_path());

        $asset->addPath('public', public_path());
        $asset->addPath('shared', resource_path());

        $asset->addPath('node', base_path('node_modules'));
        $asset->addPath('bower', base_path('bower_components'));

        $asset->addPath('asset', application()->getAssetsPath());
        $asset->addPath('storage', application()->getStoragePath());
        $asset->addPath('resources', application()->getResourcesPath());
        $asset->addPath('download', application()->getAssetsPath('assets/downloads'));

        $asset->addPath('streams', __DIR__ . '/../resources');
    }

    /**
     * Add the image namespace hints.
     *
     * @return void
     */
    private function addImageNamespaces()
    {
        $image = app(Image::class);

        $image->setDirectory(public_path());

        $image->addPath('public', public_path());
        $image->addPath('shared', resource_path());

        $image->addPath('node', base_path('node_modules'));
        $image->addPath('bower', base_path('bower_components'));

        $image->addPath('asset', application()->getAssetsPath());
        $image->addPath('storage', application()->getStoragePath());
        $image->addPath('resources', application()->getResourcesPath());

        $image->addPath('streams', __DIR__ . '/../resources');
    }

    /**
     * Configure the request to use HTTPS
     * if it's been configured to do so.
     *
     * This is helpful when the system
     * sits behind a load balancer that
     * can mask a secure connection.
     *
     * @return void
     */
    protected function configureRequest()
    {
        if (config('streams::system.force_ssl')) {
            request()->server->set('HTTPS', true);
        }
    }
}
