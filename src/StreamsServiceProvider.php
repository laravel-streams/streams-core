<?php

namespace Anomaly\Streams\Platform;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\View\ViewComposer;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Field\FieldObserver;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Foundation\Application as Laravel;
use Anomaly\Streams\Platform\Support\Configurator;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Stream\StreamObserver;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\AssignmentObserver;

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
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        'Anomaly\Streams\Platform\Lock\Contract\LockRepositoryInterface'             => \Anomaly\Streams\Platform\Lock\LockRepository::class,
        'Anomaly\Streams\Platform\Addon\Contract\AddonRepositoryInterface'           => \Anomaly\Streams\Platform\Addon\AddonRepository::class,
        'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface'           => \Anomaly\Streams\Platform\Entry\EntryRepository::class,
        'Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface'           => \Anomaly\Streams\Platform\Field\FieldRepository::class,
        'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface'         => \Anomaly\Streams\Platform\Stream\StreamRepository::class,
        'Anomaly\Streams\Platform\Model\Contract\EloquentRepositoryInterface'        => \Anomaly\Streams\Platform\Model\EloquentRepository::class,
        'Anomaly\Streams\Platform\Version\Contract\VersionRepositoryInterface'       => \Anomaly\Streams\Platform\Version\VersionRepository::class,
        'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface' => \Anomaly\Streams\Platform\Assignment\AssignmentRepository::class,

        'addon.collection'      => \Anomaly\Streams\Platform\Addon\AddonCollection::class,
        'theme.collection'      => \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class,
        'module.collection'     => \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class,
        'extension.collection'  => \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class,
        'field_type.collection' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class,
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
        \Anomaly\Streams\Platform\Image\Image::class             => \Anomaly\Streams\Platform\Image\Image::class,
        \Anomaly\Streams\Platform\Stream\StreamStore::class      => \Anomaly\Streams\Platform\Stream\StreamStore::class,
        \Anomaly\Streams\Platform\Message\MessageBag::class      => \Anomaly\Streams\Platform\Message\MessageBag::class,
        \Anomaly\Streams\Platform\Routing\UrlGenerator::class    => \Anomaly\Streams\Platform\Routing\UrlGenerator::class,
        \Anomaly\Streams\Platform\Addon\AddonCollection::class   => \Anomaly\Streams\Platform\Addon\AddonCollection::class,
        \Anomaly\Streams\Platform\Application\Application::class => \Anomaly\Streams\Platform\Application\Application::class,

        \Anomaly\Streams\Platform\Support\Parser::class     => \Anomaly\Streams\Platform\Support\Parser::class,
        \Anomaly\Streams\Platform\Support\Hydrator::class   => \Anomaly\Streams\Platform\Support\Hydrator::class,
        \Anomaly\Streams\Platform\Support\Resolver::class   => \Anomaly\Streams\Platform\Support\Resolver::class,
        \Anomaly\Streams\Platform\Support\Authorizer::class => \Anomaly\Streams\Platform\Support\Authorizer::class,
        \Anomaly\Streams\Platform\Support\Translator::class => \Anomaly\Streams\Platform\Support\Translator::class,

        \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class         => \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class,
        \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class       => \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class,
        \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class => \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class,
        \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class,

        \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class                     => \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class,
        \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class                 => \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class,
        \Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection::class => \Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection::class,
        \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class => \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class     => \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class => \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class,

        \Anomaly\Streams\Platform\View\ViewComposer::class        => \Anomaly\Streams\Platform\View\ViewComposer::class,
        \Anomaly\Streams\Platform\View\ViewOverrides::class       => \Anomaly\Streams\Platform\View\ViewOverrides::class,
        \Anomaly\Streams\Platform\View\ViewMobileOverrides::class => \Anomaly\Streams\Platform\View\ViewMobileOverrides::class,

        \Anomaly\Streams\Platform\Support\Purifier::class         => \Anomaly\Streams\Platform\Support\Purifier::class,
        \Anomaly\Streams\Platform\Field\FieldRouter::class        => \Anomaly\Streams\Platform\Field\FieldRouter::class,
    ];

    /**
     * Boot the service provider.
     */
    public function boot()
    {

        // Take care of core utilities.
        $this->initializeApplication();

        // Setup and preparing utilities.
        $this->loadStreamsConfiguration();
        $this->registerAddonCollections();
        $this->configureFileCacheStore();
        $this->routeAutomatically();
        $this->addAssetNamespaces();
        $this->addImageNamespaces();
        $this->addThemeNamespaces();
        $this->addViewNamespaces();
        $this->loadTranslations();

        // Observe our base models.
        EntryModel::observe(EntryObserver::class);
        FieldModel::observe(FieldObserver::class);
        StreamModel::observe(StreamObserver::class);
        EloquentModel::observe(EloquentObserver::class);
        AssignmentModel::observe(AssignmentObserver::class);

        /**
         * Register core commands.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([

                // Asset Commands
                \Anomaly\Streams\Platform\Asset\Console\AssetsClear::class,
                \Anomaly\Streams\Platform\Asset\Console\AssetsPublish::class,

                // Installer Commands
                \Anomaly\Streams\Platform\Installer\Console\Install::class,

                // Streams Commands
                \Anomaly\Streams\Platform\Stream\Console\StreamsIndex::class,
                \Anomaly\Streams\Platform\Stream\Console\StreamsCleanup::class,
                \Anomaly\Streams\Platform\Stream\Console\StreamsDestroy::class,

                // Addon Commands
                \Anomaly\Streams\Platform\Addon\Console\AddonSeed::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonReset::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonInstall::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonMigrate::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonUninstall::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonReinstall::class,

                // Application Commands
                \Anomaly\Streams\Platform\Application\Console\Build::class,
                \Anomaly\Streams\Platform\Application\Console\EnvSet::class,
                \Anomaly\Streams\Platform\Application\Console\Refresh::class,
            ]);
        }

        /**
         * Register publishables.
         */
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets' => public_path(
                implode(DIRECTORY_SEPARATOR, ['vendor', 'anomaly', 'core'])
            )
        ], 'assets');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

        $this->registerComposerJson();
        $this->registerComposerLock();

        /**
         * Load core routes.
         */
        Route::middleware('web')
            ->group(base_path('vendor/anomaly/streams-platform/resources/routes/web.php'));
    }

    /**
     * Register the composer file data.
     */
    protected function registerComposerJson()
    {
        $this->app->singleton(
            'composer.json',
            function () {
                return json_decode(file_get_contents(base_path('composer.json')), true);
            }
        );
    }

    /**
     * Register the composer lock file data.
     */
    protected function registerComposerLock()
    {
        $this->app->singleton(
            'composer.lock',
            function () {
                return json_decode(file_get_contents(base_path('composer.lock')), true);
            }
        );
    }

    /**
     * Register addon collections.
     */
    protected function registerAddonCollections()
    {
        $this->app->singleton(AddonCollection::class, function () {

            $lock = json_decode(file_get_contents(base_path('composer.lock')), true);

            $addons = array_filter($lock['packages'], function (array $package) {
                return array_get($package, 'type') == 'streams-addon';
            });

            $addons = array_combine(array_map(function ($addon) {

                [$vendor, $addon, $type] = preg_split("/(\/|-)/", $addon['name']);

                return "{$vendor}.{$type}.{$addon}";
            }, $addons), $addons);

            array_walk($addons, function (&$addon, $namespace) {
                $addon['namespace'] = $namespace;
            });

            ksort($addons);

            return new AddonCollection($addons);
        });

        app(AddonCollection::class)->disperse();
    }

    /**
     * Initialize the Streams application.
     */
    protected function initializeApplication()
    {
        $reference = env('APP_REFERENCE', 'default');

        $application = application();

        /*
         * Set the reference to our default first.
         * When in a dev environment and working
         * with Artisan this the same as locating.
         */
        $application->setReference($reference);
    }

    /**
     * Load the streams configuration.
     *
     * @return void
     */
    protected function loadStreamsConfiguration()
    {

        // Load package configuration.
        Configurator::load(realpath(__DIR__ . '/../resources/config'), 'streams');

        // Load application overrides.
        // if (is_dir($directory = application()->getResourcesPath('streams/config'))) {
        //     Configurator::merge($directory, 'streams');
        // }

        // Load system overrides.
        Configurator::merge(base_path('resources/streams/config'), 'streams');
    }

    /**
     * Configure the file cache store so that cache doesn't collide
     * in the event that there are multiple applications running.
     *
     * @return void
     */
    protected function configureFileCacheStore()
    {
        config(['cache.stores.file.path' => config('cache.stores.file.path') . DIRECTORY_SEPARATOR . application()->getReference()]);
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

        $asset->addPath('streams', base_path('vendor/anomaly/streams-platform/resources'));
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

        $image->addPath('streams', base_path('vendor/anomaly/streams-platform/resources'));
    }

    /**
     * Add view namespaces.
     * 
     * @deprecated  2.0 - Remove
     */
    public function addViewNamespaces()
    {
        $views = view();

        /**
         * We still need the composer
         * for $view->make() overloading.
         * 
         * @todo Remove this. Publishing should be used.
         */
        //$views->composer('*', ViewComposer::class);

        $views->addNamespace('streams', base_path('vendor/anomaly/streams-platform/resources/views'));
        $views->addNamespace('storage', application()->getStoragePath());
        $views->addNamespace('shared', base_path('resources/views'));
        $views->addNamespace('theme', base_path('resources/views'));
        $views->addNamespace('app', app_resources_path('views'));
        $views->addNamespace('root', base_path());

        //$views->addExtension('html', 'php');
    }

    /**
     * Add the active theme hints.
     */
    public function addThemeNamespaces()
    {
        $view = view();
        $image = img();
        $trans = trans();
        $assets = assets();

        if ($default = config('streams::themes.default')) {

            $path = app($default)->getPath();

            $view->addNamespace('theme', $path . '/resources/views');
            $trans->addNamespace('theme', $path . '/resources/lang');

            $assets->addPath('theme', $path . '/resources');
            $image->addPath('theme', $path . '/resources');
        }

        if (!$default) {

            $path = base_path('resources');

            $view->addNamespace('theme', $path . '/views');
            $trans->addNamespace('theme', $path . '/lang');

            $assets->addPath('theme', $path);
            $image->addPath('theme', $path);
        }

        if ($admin = config('streams::themes.admin')) {

            $path = app($admin)->getPath();

            $view->addNamespace('admin', $path . '/resources/views');
            $trans->addNamespace('admin', $path . '/resources/lang');

            $assets->addPath('admin', $path . '/resources');
            $image->addPath('admin', $path . '/resources');
        }
    }

    /**
     * Load translations.
     */
    public function loadTranslations()
    {
        trans()->addNamespace('streams', base_path('vendor/anomaly/streams-platform/resources/lang'));
    }

    /**
     * Attempt to route the request automatically.
     *
     * Huge thanks to @frednwt for this one.
     */
    protected function routeAutomatically()
    {
        $request = request();

        /**
         * This only applies to admin
         * controllers at this time.
         */
        if ($request->segment(1) !== 'admin') {
            return;
        }

        /**
         * Use the segments to figure
         * out what we need to do.
         */
        $segments = $request->segments();

        /**
         * Remove "admin"
         * from beginning.
         */
        array_shift($segments);

        /**
         * This is just /admin
         */
        if (!$segments) {
            return;
        }

        /**
         * The first segment MUST
         * be a unique addon slug.
         *
         * @var Addon $addon
         */
        try {
            $addon = app('addon.collection')->first(function ($addon) use ($segments) {
                return str_is('*.*.' . $segments[0], $addon['namespace']);
            });
        } catch (\Exception $exception) {
            return; // Doesn't exist.
        }

        $namespace = (new \ReflectionClass(app($addon['namespace'])))->getNamespaceName();

        $controller = null;
        $module     = null;
        $stream     = null;
        $method     = null;
        $path       = null;
        $id         = null;


        if (count($segments) == 1) {
            $module = $segments[0];
            $stream = $segments[0];
            $method = 'index';

            $path = implode('/', ['admin', $module]);

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 2) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = 'index';

            $path = implode('/', ['admin', $module, $stream]);

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;

            if (!class_exists($controller)) {
                $controller = null;
            }
        }

        if (!$controller && count($segments) == 2) {
            $module = $segments[0];
            $stream = $segments[0];
            $method = $segments[1];

            $path = implode('/', array_unique(['admin', $module, $stream, $method]));

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 3) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = $segments[2];

            $path = implode('/', ['admin', $module, $stream, $method]);

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;

            if (!class_exists($controller)) {
                $controller = null;
            }
        }

        if (!$controller && count($segments) == 3) {
            $module = $segments[0];
            $stream = $segments[0];
            $method = $segments[1];
            $id     = '{id}';

            $path = implode('/', array_unique(['admin', $module, $stream, $method, $id]));

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 4) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = $segments[2];
            $id     = '{id}';

            $path = implode('/', ['admin', $module, $stream, $method, $id]);

            $controller = ucfirst(studly_case($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        /**
         * If the route has already been
         * defined then let it handle itself.
         */
        try {
            \Route::getRoutes()->match($request);

            return;
        } catch (\Exception $exception) {
            // Not found. Onward!
        }

        if (!class_exists($controller)) {
            return;
        }

        \Route::middleware('web')->group(function () use ($path, $method, $controller) {
            \Route::any(
                $path,
                [
                    'uses' => $controller . '@' . $method,
                ]
            );
        });
    }
}
