<?php

namespace Anomaly\Streams\Platform;

use Exception;
use Parsedown;
use Misd\Linkify\Linkify;
use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Purifier;
use Anomaly\Streams\Platform\View\ViewIncludes;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Image\Facades\Images;
use Anomaly\Streams\Platform\Stream\StreamBuilder;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Ui\Table\TableComponent;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Illuminate\Support\Collection as SupportCollection;
use Anomaly\Streams\Platform\Http\Controller\EntryController;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

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
     * The class aliases.
     *
     * @var array
     */
    public $aliases = [
        'Streams' => \Anomaly\Streams\Platform\Support\Facades\Streams::class
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        'addon.collection'      => \Anomaly\Streams\Platform\Addon\AddonCollection::class,
        'theme.collection'      => \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class,
        'module.collection'     => \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class,
        'extension.collection'  => \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class,
        'field_type.collection' => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class,

        \Anomaly\Streams\Platform\Addon\Contract\AddonRepositoryInterface::class    => \Anomaly\Streams\Platform\Addon\AddonRepository::class,
        \Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface::class    => \Anomaly\Streams\Platform\Entry\EntryRepository::class,
        \Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface::class    => \Anomaly\Streams\Platform\Field\FieldRepository::class,
        \Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface::class  => \Anomaly\Streams\Platform\Stream\StreamRepository::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        'includes' => \Anomaly\Streams\Platform\View\ViewIncludes::class,
        'assets'   => \Anomaly\Streams\Platform\Asset\AssetManager::class,
        'images'   => \Anomaly\Streams\Platform\Image\ImageManager::class,
        'streams'  => \Anomaly\Streams\Platform\Stream\StreamManager::class,
        'messages' => \Anomaly\Streams\Platform\Message\MessageManager::class,

        'locator' => \Anomaly\Streams\Platform\Support\Locator::class,
        'resolver' => \Anomaly\Streams\Platform\Support\Resolver::class,
        'hydrator' => \Anomaly\Streams\Platform\Support\Hydrator::class,
        'decorator' => \Anomaly\Streams\Platform\Support\Decorator::class,
        'evaluator' => \Anomaly\Streams\Platform\Support\Evaluator::class,

        \Anomaly\Streams\Platform\View\ViewIncludes::class  => \Anomaly\Streams\Platform\View\ViewIncludes::class,
        \Anomaly\Streams\Platform\Asset\AssetManager::class => \Anomaly\Streams\Platform\Asset\AssetManager::class,
        \Anomaly\Streams\Platform\Image\ImageManager::class => \Anomaly\Streams\Platform\Image\ImageManager::class,

        \Anomaly\Streams\Platform\Stream\StreamManager::class    => \Anomaly\Streams\Platform\Stream\StreamManager::class,
        \Anomaly\Streams\Platform\Addon\AddonCollection::class   => \Anomaly\Streams\Platform\Addon\AddonCollection::class,
        \Anomaly\Streams\Platform\Message\MessageManager::class  => \Anomaly\Streams\Platform\Message\MessageManager::class,
        \Anomaly\Streams\Platform\Application\Application::class => \Anomaly\Streams\Platform\Application\Application::class,

        \Anomaly\Streams\Platform\Addon\AddonManager::class => \Anomaly\Streams\Platform\Addon\AddonManager::class,

        \Anomaly\Streams\Platform\Stream\StreamRegistry::class => \Anomaly\Streams\Platform\Stream\StreamRegistry::class,

        \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class         => \Anomaly\Streams\Platform\Addon\Theme\ThemeCollection::class,
        \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class       => \Anomaly\Streams\Platform\Addon\Module\ModuleCollection::class,
        \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class => \Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection::class,
        \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class => \Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection::class,

        \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class                     => \Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class,
        \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class                 => \Anomaly\Streams\Platform\Ui\Button\ButtonRegistry::class,
        \Anomaly\Streams\Platform\Support\Breadcrumb::class       => \Anomaly\Streams\Platform\Support\Breadcrumb::class,
        \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class      => \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class     => \Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry::class,
        \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class => \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry::class,

    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerComposerJson();
        $this->registerComposerLock();
        $this->registerFieldTypes();
        $this->registerAliases();
        $this->registerStreams();

        /**
         * @todo ?
         */
        EloquentCollection::macro('ids', function () {
            return $this->pluck('id')->all();
        });

        /**
         * Load core routes.
         */
        Route::middleware('web')
            ->group(base_path('vendor/anomaly/streams-platform/resources/routes/web.php'));

        Route::middlewareGroup('cp', config('streams.cp.middleware', ['auth']));

        if (file_exists($routes = base_path('routes/cp.php'))) {
            Route::prefix(config('streams.cp.prefix', 'admin'))
                ->middleware('cp')
                ->group($routes);
        }
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->singleton('parser_data', function() {

            $data = [
                'request' => [
                    'url' => Request::url(),
                    'path' => Request::path(),
                    'root' => Request::root(),
                    'input' => Request::input(),
                    'full_url' => Request::fullUrl(),
                    'segments' => Request::segments(),
                    'uri' => Request::getRequestUri(),
                    'query' => Request::getQueryString(),
                ],
                'url' => [
                    'previous' => URL::previous(),
                ]
            ];

            if ($route = Request::route()) {
                
                $data['route'] = [
                    'uri' => $route->uri(),
                    'parameters' => $route->parameters(),
                    'parameters.to_urlencoded' => array_map(
                        function ($parameter) {
                            return urlencode($parameter);
                        },
                        array_filter($route->parameters())
                    ),
                    'parameter_names' => $route->parameterNames(),
                    'compiled' => [
                        'static_prefix' => $route->getCompiled()->getStaticPrefix(),
                        'parameters_suffix' => str_replace(
                            $route->getCompiled()->getStaticPrefix(),
                            '',
                            Request::getRequestUri()
                        ),
                    ],
                ];
            }

            return $data;
        });

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
        $this->setActiveTheme();
        $this->extendLang();
        $this->extendView();
        $this->extendArr();
        $this->extendStr();

        /**
         * Register Blade components.
         */
        Blade::component('ui-table', TableComponent::class);

        /**
         * Register core commands.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([

                // Asset Commands
                \Anomaly\Streams\Platform\Asset\Console\AssetsClear::class,
                \Anomaly\Streams\Platform\Asset\Console\AssetsPublish::class,

                // Addon Commands
                \Anomaly\Streams\Platform\Addon\Console\AddonSeed::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonReset::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonInstall::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonMigrate::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonUninstall::class,
                \Anomaly\Streams\Platform\Addon\Console\AddonReinstall::class,

                // Application Commands
                \Anomaly\Streams\Platform\Application\Console\Build::class,
                \Anomaly\Streams\Platform\Application\Console\Refresh::class,
            ]);
        }

        /**
         * Register publishables.
         */
        // $this->publishes([
        //     base_path('vendor/anomaly/streams-platform/resources/dist') => public_path(
        //         implode(DIRECTORY_SEPARATOR, ['vendor', 'anomaly', 'core'])
        //     )
        // ], ['assets', 'public']);
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
     * Register the field types.
     */
    protected function registerFieldTypes()
    {
        $this->app->bind('text', \Anomaly\Streams\Platform\Field\Type\Text::class);
        $this->app->bind('bool', \Anomaly\Streams\Platform\Field\Type\Boolean::class);
        $this->app->bind('boolean', \Anomaly\Streams\Platform\Field\Type\Boolean::class);
        $this->app->bind('textarea', \Anomaly\Streams\Platform\Field\Type\Textarea::class);
    }
    
    /**
     * Register Aliases.
     */
    protected function registerAliases()
    {
        AliasLoader::getInstance($this->aliases)->register();
    }

    /**
     * Register Streams.
     */
    protected function registerStreams()
    {
        foreach (File::files(base_path('streams')) as $file) {

            if (!$stream = json_decode(file_get_contents($file->getPathname()), true)) {
                throw new Exception("Failed to parse JSON: {$file->getPathname()}");
            }

            $stream = StreamBuilder::build($stream);

            $this->app->instance(
                'streams::' . $file->getBasename('.' . $file->getExtension()),
                $stream
            );


            if ($stream->route) {

                Route::any($stream->route, [
                    'stream' => $stream->slug,
                    'uses' => $stream->attr('uses', EntryController::class . '@render'),
                ]);
            }
        }
    }

    /**
     * Register addon collections.
     */
    protected function registerAddonCollections()
    {
        $this->app->singleton(AddonCollection::class, function () {

            if (config('streams.installed')) {
                // $states = AddonModel::get();
                $states = new EloquentCollection;
            } else {
                $states = new EloquentCollection;
            }

            $lock = json_decode(file_get_contents(base_path('composer.lock')), true);

            $addons = array_filter(array_merge($lock['packages'], $lock['packages-dev']), function (array $package) {
                return Arr::get($package, 'type') == 'streams-addon';
            });

            $addons = array_combine(array_map(function ($addon) {

                [$vendor, $addon, $type] = preg_split("/(\/|-)/", $addon['name']);

                return "{$vendor}.{$type}.{$addon}";
            }, $addons), $addons);

            array_walk($addons, function (&$addon, $namespace) use ($states) {

                $addon['namespace'] = $namespace;

                if ($state = $states->where('namespace', $namespace)->first()) {
                    $addon['enabled'] = $state->enabled;
                    $addon['installed'] = $state->installed;
                }

                [$vendor, $slug, $type] = preg_split("/(\/|-)/", $addon['name']);

                $addon['class'] = implode('\\', [
                    Str::studly($vendor),
                    Str::studly($slug . '_' . $type),
                ]);

                $addon['provider'] = implode('\\', [
                    Str::studly($vendor),
                    Str::studly($slug . '_' . $type),
                    Str::studly($slug . '_' . $type) . 'ServiceProvider',
                ]);

                (new $addon['provider']($this->app))->registerAddon();
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

        $application = app(Application::class);

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
        $this->mergeConfigFrom(realpath(__DIR__ . '/../resources/config/streams.php'), 'streams');
    }

    /**
     * Configure the file cache store so that cache doesn't collide
     * in the event that there are multiple applications running.
     *
     * @return void
     */
    protected function configureFileCacheStore()
    {
        config(['cache.stores.file.path' => config('cache.stores.file.path') . DIRECTORY_SEPARATOR . app(Application::class)->getReference()]);
    }

    /**
     * Add the asset namespace hints.
     */
    protected function addAssetNamespaces()
    {
        Assets::addPath('public', public_path());
        Assets::addPath('shared', resource_path());

        Assets::addPath('node', base_path('node_modules'));
        Assets::addPath('bower', base_path('bower_components'));

        Assets::addPath('asset', app(Application::class)->getAssetsPath());
        Assets::addPath('storage', app(Application::class)->getStoragePath());
        Assets::addPath('resources', app(Application::class)->getResourcesPath());
        Assets::addPath('download', app(Application::class)->getAssetsPath('assets/downloads'));

        Assets::addPath('streams', base_path('vendor/anomaly/streams-platform/resources'));
    }

    /**
     * Add the image namespace hints.
     *
     * @return void
     */
    private function addImageNamespaces()
    {
        Images::addPath('public', public_path());
        Images::addPath('shared', resource_path());

        Images::addPath('node', base_path('node_modules'));
        Images::addPath('bower', base_path('bower_components'));

        Images::addPath('asset', app(Application::class)->getAssetsPath());
        Images::addPath('storage', app(Application::class)->getStoragePath());
        Images::addPath('resources', app(Application::class)->getResourcesPath());

        Images::addPath('streams', base_path('vendor/anomaly/streams-platform/resources'));
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
        $views->addNamespace('storage', app(Application::class)->getStoragePath());
        $views->addNamespace('shared', base_path('resources/views'));
        $views->addNamespace('theme', base_path('resources/views'));
        $views->addNamespace('root', base_path());

        //$views->addExtension('html', 'php');
    }

    /**
     * Add the active theme hints.
     */
    public function addThemeNamespaces()
    {
        // @todo REMOVE THIS
        return;

        $view = view();
        $image = img();
        $trans = trans();
        $assets = assets();

        if ($default = config('streams.themes.default')) {

            $path = app($default)->path;

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

        if ($admin = config('streams.themes.admin')) {

            $path = app($admin)->path;

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
     * Load translations.
     */
    protected function setActiveTheme()
    {
        $theme = config('streams.themes.default');

        if (request()->segment(1) == 'admin') {
            $theme = config('streams.themes.admin');
        }

        app('theme.collection')->setActive($theme);
    }

    /**
     * Extend the lang system.
     */
    protected function extendLang()
    {
        Translator::macro('translate', function ($target) {

            if (is_array($target) || $target instanceof SupportCollection) {
                foreach ($target as &$value) {
                    $value = Lang::translate($value);
                }
            }

            if (is_string($target) && Str::contains($target, ['::', '.'])) {
                return trans($target);
            }

            return $target;
        });
    }

    /**
     * Extend the view system.
     */
    protected function extendView()
    {
        Factory::macro('parse', function ($template, array $payload = []) {
            return app(ViewTemplate::class)->parse($template, $payload);
        });

        Factory::macro('include', function ($slot, $include = null) {

            if (is_array($slot)) {

                foreach ($slot as $name => $includes) {
                    foreach ($includes as $include) {
                        View::include($name, $include);
                    }
                }

                return;
            }

            app(ViewIncludes::class)->include($slot, $include);
        });

        Factory::macro('includes', function ($slot, array $payload = []) {
            return app('includes')->get($slot, function () {
                return new EloquentCollection;
            })->map(function ($item) use ($payload) {
                return View::make($item, $payload)->render();
            })->implode("\n");
        });
    }

    /**
     * Extend the array utility.
     */
    protected function extendArr()
    {
        Arr::macro('make', function ($target) {

            if (Arr::accessible($target)) {
                foreach ($target as &$item) {
                    $item = Arr::make($item);
                }
            }

            if (is_object($target) && $target instanceof Arrayable) {
                $target = $target->toArray();
            }

            if (is_object($target)) {
                $target = Hydrator::dehydrate($target);
            }

            return $target;
        });

        Arr::macro('parse', function ($target, array $payload = []) {

            $payload = Arr::make($payload);

            foreach ($target as &$value) {

                if (is_array($value)) {
                    $value = Arr::parse($value, $payload);
                }

                if (is_string($value)) {
                    $value = Str::parse($value, $payload);
                }
            }

            return $target;
        });
    }

    /**
     * Extend the string utility.
     */
    protected function extendStr()
    {
        Str::macro('humanize', function ($value, $separator = '_') {
            return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
        });

        Str::macro('purify', function ($value) {
            return app(Purifier::class)->purify($value);
        });

        Str::macro('purify', function ($text, array $options = []) {
            return (new Linkify($options))->process($text);
        });

        Str::macro('truncate', function ($value, $limit = 100, $end = '...') {

            if (strlen($value) <= $limit) {
                return $value;
            }

            $parts  = preg_split('/([\s\n\r]+)/', $value, null, PREG_SPLIT_DELIM_CAPTURE);
            $count  = count($parts);
            $length = 0;

            for ($last = 0; $last < $count; ++$last) {

                $length += strlen($parts[$last]);

                if ($length > $limit) {
                    break;
                }
            }

            return trim(implode(array_slice($parts, 0, $last))) . $end;
        });

        Str::macro('parse', function ($target, array $data = []) {
            return app(Engine::class)->render($target, array_merge(app('parser_data'), Arr::make($data)));
        });

        Str::macro('markdown', function ($target, array $data = []) {
            return (new Parsedown)->parse($target, array_merge(app('parser_data'), Arr::make($data)));
        });
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
        if ($request->segment(1) !== config('streams.cp.prefix', 'admin')) {
            return;
        }

        /**
         * Use the segments to figure
         * out what we need to do.
         */
        $segments = $request->segments();

        /**
         * Remove CP prefix.
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
         */
        if (!$addon = app('addon.collection')->first(function ($addon) use ($segments) {
            return Str::is('*.*.' . $segments[0], $addon['namespace']);
        })) {
            return;
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

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 2) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = 'index';

            $path = implode('/', ['admin', $module, $stream]);

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
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

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 3) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = $segments[2];

            $path = implode('/', ['admin', $module, $stream, $method]);

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
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

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        if (count($segments) == 4) {
            $module = $segments[0];
            $stream = $segments[1];
            $method = $segments[2];
            $id     = '{id}';

            $path = implode('/', ['admin', $module, $stream, $method, $id]);

            $controller = ucfirst(Str::studly($stream)) . 'Controller';
            $controller = $namespace . '\Http\Controller\Admin\\' . $controller;
        }

        /**
         * If the route has already been
         * defined then let it handle itself.
         */
        try {
            Route::getRoutes()->match($request);
        } catch (\Exception $exception) {
            // 404 == Onward!
        }

        /**
         * Make sure the assumed controller exists.
         */
        if (!class_exists($controller)) {
            return;
        }

        /**
         * Route the request automatically.
         */
        Route::middleware('web')->group(function () use ($path, $method, $controller) {
            Route::any(
                $path,
                [
                    'uses' => $controller . '@' . $method,
                ]
            );
        });
    }
}
