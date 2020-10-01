<?php

namespace Anomaly\Streams\Platform;

use HTMLPurifier;
use Misd\Linkify\Linkify;
use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\View\ViewIncludes;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Support\Facades\Assets;
use Anomaly\Streams\Platform\Support\Facades\Images;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Illuminate\Support\Collection as SupportCollection;
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
        'Assets' => \Anomaly\Streams\Platform\Support\Facades\Assets::class,
        'Images' => \Anomaly\Streams\Platform\Support\Facades\Images::class,
        'Streams' => \Anomaly\Streams\Platform\Support\Facades\Streams::class,
        'Includes' => \Anomaly\Streams\Platform\Support\Facades\Includes::class,
        'Messages' => \Anomaly\Streams\Platform\Support\Facades\Messages::class,
        'Application' => \Anomaly\Streams\Platform\Support\Facades\Application::class,
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        'streams.addons'      => \Anomaly\Streams\Platform\Addon\AddonCollection::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        'includes'     => \Anomaly\Streams\Platform\View\ViewIncludes::class,
        'assets'       => \Anomaly\Streams\Platform\Asset\AssetManager::class,
        'images'       => \Anomaly\Streams\Platform\Image\ImageManager::class,
        'streams'      => \Anomaly\Streams\Platform\Stream\StreamManager::class,
        'messages'     => \Anomaly\Streams\Platform\Message\MessageManager::class,
        'applications' => \Anomaly\Streams\Platform\Application\ApplicationManager::class,

        'locator' => \Anomaly\Streams\Platform\Support\Locator::class,
        'resolver' => \Anomaly\Streams\Platform\Support\Resolver::class,
        'hydrator' => \Anomaly\Streams\Platform\Support\Hydrator::class,
        'decorator' => \Anomaly\Streams\Platform\Support\Decorator::class,
        'evaluator' => \Anomaly\Streams\Platform\Support\Evaluator::class,
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
        $this->registerApplications();
        $this->registerFieldTypes();
        $this->registerMiddleware();


        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }


        $this->registerAliases();
        $this->registerConfig();


        $this->extendUrlGenerator();
        $this->extendCollection();
        $this->extendRouter();
        $this->extendLang();
        $this->extendView();
        $this->extendArr();
        $this->extendStr();

        $this->registerStreams();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // Register the application.
        $this->app->singleton('streams.application', function () {
            return $this->app->make('streams.applications.default');
        });

        $this->app->singleton('streams.application.origin', function () {
            return $this->app->make('streams.applications.default');
        });

        $this->app->singleton('streams.application.handle', function () {
            return $this->app->make('streams.applications.default')->handle;
        });

        $this->app->singleton('streams.parser_data', function () {

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

        // Setup and preparing utilities.
        $this->registerAddonCollection();
        $this->configureFileCacheStore();
        $this->addAssetNamespaces();
        $this->addImageNamespaces();
        $this->addViewNamespaces();
        $this->loadTranslations();
        // $this->extendLang();
        // $this->extendView();
        // $this->extendArr();
        // $this->extendStr();

        /**
         * Register Sterams
         *
         * @todo this needs pushed up into the register() method
         */
        //$this->registerStreams();

        /**
         * Register core commands.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([

                // Asset Commands
                \Anomaly\Streams\Platform\Asset\Console\AssetsClear::class,
                \Anomaly\Streams\Platform\Asset\Console\AssetsPublish::class,

                // Addon Commands
                //\Anomaly\Streams\Platform\Addon\Console\AddonPublish::class,
            ]);
        }

        /**
         * Register publishables.
         */
        $this->publishes([
            base_path('vendor/anomaly/streams-platform/docs') => base_path(
                implode(DIRECTORY_SEPARATOR, ['docs', 'core'])
            )
        ], ['docs']);
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
     * Register the applications(s).
     */
    protected function registerApplications()
    {
        $applications = Config::get('streams.applications', []) ?: ['default' => []];

        foreach ($applications as $handle => $configuration) {

            $configuration['handle'] = $handle;

            $this->app->singleton('streams.applications.' . $handle, function () use ($configuration) {
                return new Application($configuration);
            });
        }
    }

    /**
     * Register the field types.
     * @todo Finish up
     */
    protected function registerFieldTypes()
    {
        // Text
        $this->app->bind('streams.field_types.url', \Anomaly\Streams\Platform\Field\Type\Url::class);
        $this->app->bind('streams.field_types.text', \Anomaly\Streams\Platform\Field\Type\Text::class);
        $this->app->bind('streams.field_types.string', \Anomaly\Streams\Platform\Field\Type\Text::class);
        $this->app->bind('streams.field_types.textarea', \Anomaly\Streams\Platform\Field\Type\Text::class);
        $this->app->bind('streams.field_types.template', \Anomaly\Streams\Platform\Field\Type\Template::class);

        // Array
        $this->app->bind('streams.field_types.array', \Anomaly\Streams\Platform\Field\Type\Arr::class);

        // Integers
        $this->app->bind('streams.field_types.int', \Anomaly\Streams\Platform\Field\Type\Integer::class);
        $this->app->bind('streams.field_types.integer', \Anomaly\Streams\Platform\Field\Type\Integer::class);

        // Decimals
        $this->app->bind('streams.field_types.float', \Anomaly\Streams\Platform\Field\Type\Decimal::class);
        $this->app->bind('streams.field_types.double', \Anomaly\Streams\Platform\Field\Type\Decimal::class);
        $this->app->bind('streams.field_types.decimal', \Anomaly\Streams\Platform\Field\Type\Decimal::class);

        // Boolean
        $this->app->bind('streams.field_types.bool', \Anomaly\Streams\Platform\Field\Type\Boolean::class);
        $this->app->bind('streams.field_types.boolean', \Anomaly\Streams\Platform\Field\Type\Boolean::class);

        // Dates
        $this->app->bind('streams.field_types.date', \Anomaly\Streams\Platform\Field\Type\Datetime::class);
        $this->app->bind('streams.field_types.time', \Anomaly\Streams\Platform\Field\Type\Datetime::class);
        $this->app->bind('streams.field_types.datetime', \Anomaly\Streams\Platform\Field\Type\Datetime::class);

        // Assets
        //$this->app->bind('streams.field_types.asset', \Anomaly\Streams\Platform\Field\Type\Asset::class);
        $this->app->bind('streams.field_types.image', \Anomaly\Streams\Platform\Field\Type\Image::class);

        // Objects
        //$this->app->bind('streams.field_types.object', \Anomaly\Streams\Platform\Field\Type\Object::class);
        $this->app->bind('streams.field_types.collection', \Anomaly\Streams\Platform\Field\Type\Collection::class);

        // Streams
        $this->app->bind('streams.field_types.entry', \Anomaly\Streams\Platform\Field\Type\Entry::class);
        $this->app->bind('streams.field_types.entries', \Anomaly\Streams\Platform\Field\Type\Entries::class);

        // Relationships
        $this->app->bind('streams.field_types.multiple', \Anomaly\Streams\Platform\Field\Type\Multiple::class);
        $this->app->bind('streams.field_types.polymorphic', \Anomaly\Streams\Platform\Field\Type\Polymorphic::class);
        $this->app->bind('streams.field_types.relationship', \Anomaly\Streams\Platform\Field\Type\Relationship::class);
    }

    /**
     * Register middleware.
     */
    protected function registerMiddleware()
    {
        Route::middlewareGroup('cp', Config::get('streams.cp.middleware', ['auth']));
    }

    /**
     * Register Aliases.
     */
    protected function registerAliases()
    {
        AliasLoader::getInstance($this->aliases)->register();
    }

    /**
     * Register config.
     */
    protected function registerConfig()
    {
        // Create the Streams config.
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/cp.php', 'streams.cp');
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/addons.php', 'streams.addons');
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/images.php', 'streams.images');
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/system.php', 'streams.system');
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/sources.php', 'streams.sources');

        // Merge overrides if present.
        if (file_exists($config = __DIR__ . '/../../../../config/streams/cp.php')) {
            $this->mergeConfigFrom($config, 'streams.cp');
        }
        if (file_exists($config = __DIR__ . '/../../../../config/streams/addons.php')) {
            $this->mergeConfigFrom($config, 'streams.addons');
        }
        if (file_exists($config = __DIR__ . '/../../../../config/streams/images.php')) {
            $this->mergeConfigFrom($config, 'streams.images');
        }
        if (file_exists($config = __DIR__ . '/../../../../config/streams/system.php')) {
            $this->mergeConfigFrom($config, 'streams.system');
        }
        if (file_exists($config = __DIR__ . '/../../../../config/streams/sources.php')) {
            $this->mergeConfigFrom($config, 'streams.sources');
        }

        // Publish config.
        $this->publishes([
            __DIR__ . '/../resources/config/cp.php' => config_path('streams/cp.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/config/addons.php' => config_path('streams/addons.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/config/images.php' => config_path('streams/images.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/config/system.php' => config_path('streams/system.php')
        ], 'config');
        $this->publishes([
            __DIR__ . '/../resources/config/sources.php' => config_path('streams/sources.php')
        ], 'config');
    }

    /**
     * Register Streams.
     */
    protected function registerStreams()
    {
        foreach (File::files(base_path('streams')) as $file) {

            $stream = Streams::load($file->getPathname());

            foreach ($stream->routes ?: [] as $key => $route) {

                if (is_string($route)) {
                    $route = [
                        'uri' => $route,
                    ];
                }

                if (!isset($route['stream'])) {
                    $route['stream'] = $stream->handle;
                }

                if (!isset($route['as'])) {
                    $route['as'] = Arr::get($route, 'as', 'streams::' . $stream->handle . '.' . $key);
                }

                Route::streams(Arr::get($route, 'uri'), $route);
            }
        }
    }

    /**
     * Register addon collections.
     */
    protected function registerAddonCollection()
    {
        $this->app->singleton(AddonCollection::class, function () {

            $disabled = Config::get('streams.addons.disabled');

            $lock = json_decode(file_get_contents(base_path('composer.lock')), true);

            $addons = array_filter(
                array_merge($lock['packages'], $lock['packages-dev']),
                function (array $package) {
                    return Arr::get($package, 'type') == 'streams-addon';
                }
            );

            ksort($addons);

            $addons = array_map(function ($addon) use ($disabled) {

                $addon['enabled'] = in_array($addon['name'], $disabled);

                return new Addon($addon);
            }, $addons);

            return new AddonCollection($addons);
        });
    }

    /**
     * Configure the file cache store so that cache doesn't collide
     * in the event that there are multiple applications running.
     *
     * @return void
     */
    protected function configureFileCacheStore()
    {
        config(['cache.stores.file.path' => config('cache.stores.file.path') . DIRECTORY_SEPARATOR . $this->app['streams.application.handle']]);
    }

    /**
     * Add the asset namespace hints.
     */
    protected function addAssetNamespaces()
    {
        Assets::addPath('public', public_path());
        Assets::addPath('resources', resource_path());
        Assets::addPath('streams', realpath(__DIR__ . '/../resources'));
    }

    /**
     * Add the image namespace hints.
     *
     * @return void
     */
    private function addImageNamespaces()
    {
        Images::addPath('public', public_path());
        Images::addPath('resources', resource_path());
        Images::addPath('streams', realpath(__DIR__ . '/../resources'));
    }

    /**
     * Add view namespaces.
     *
     * @deprecated  2.0 - Remove
     */
    public function addViewNamespaces()
    {
        View::addNamespace('streams', base_path('vendor/anomaly/streams-platform/resources/views'));
        View::addNamespace('storage', storage_path('streams'));
        View::addNamespace('theme', storage_path('resources'));
    }

    /**
     * Load translations.
     */
    public function loadTranslations()
    {
        Lang::addNamespace('streams', base_path('vendor/anomaly/streams-platform/resources/lang'));
    }

    /**
     * Extend the URL generator.
     */
    protected function extendUrlGenerator()
    {
        URL::macro('streams', function ($name, $parameters = [], array $extra = [], $absolute = true) {

            $parameters = Arr::make($parameters);

            $extra = $extra ? '?' . http_build_query($extra) : null;

            if (!$route = $this->routes->getByName($name)) {
                return URL::to(Str::parse($name, $parameters) . $extra, [], $absolute);
            }

            $uri = $route->uri();

            foreach (array_keys($parameters) as $key) {
                $uri = str_replace("{{$key}__", "{{$key}.", $uri);
            }

            return URL::to(Str::parse($uri, $parameters) . $extra, [], $absolute);
        });
    }

    /**
     * Extend the base collection.
     */
    protected function extendCollection()
    {
        Collection::macro('hasAny', function ($key) {

            $keys = is_array($key) ? $key : func_get_args();

            foreach ($keys as $value) {
                if ($this->has($value)) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Extend the router.
     */
    protected function extendRouter()
    {
        Route::macro('streams', function ($uri, $route) {

            /**
             * Replace deep entry attributes with
             * something we can reference later.
             */
            $uri = str_replace('entry.', 'entry__', $uri);

            /**
             * If the route is a controller...
             */
            if (is_string($route) && strpos($route, '@')) {
                $route = [
                    'uses' => $route,
                ];
            }

            /**
             * Assume the route is a view otherwise.
             */
            if (is_string($route) && !strpos($route, '@')) {
                $route = [
                    'view' => $route,
                    'uses' => '\Anomaly\Streams\Platform\Http\Controller\StreamsController@handle',
                ];
            }

            /**
             * Pull out route options. What's left
             * is passed in as route action data. 
             */
            $csrf        = Arr::pull($route, 'csrf');
            $verb        = Arr::pull($route, 'verb', 'get');
            $middleware  = Arr::pull($route, 'middleware', []);
            $constraints = Arr::pull($route, 'constraints', []);

            /**
             * Ensure some default
             * information is present.
             */
            if (!isset($route['uses'])) {
                $route['uses'] = '\Anomaly\Streams\Platform\Http\Controller\StreamsController@handle';
            }

            /**
             * If the route contains a
             * controller@action then 
             * create a normal route.
             * -----------------------
             * If the route does NOT
             * contain an action then
             * treat it as a resource.
             */
            if (str_contains($route['uses'], '@')) {
                $route = Route::{$verb}($uri, $route);
            } else {
                $route = Route::resource($uri, $route['uses']);
            }

            /**
             * Call constraints if
             * any are provided.
             */
            if ($constraints) {
                call_user_func_array([$route, 'constraints'], (array) $constraints);
            }

            /**
             * Call middleware if
             * any are provided.
             */
            if ($middleware) {
                call_user_func_array([$route, 'middleware'], (array) $middleware);
            }

            /**
             * Disable CSRF
             */
            if ($csrf === false) {
                call_user_func_array([$route, 'withoutMiddleware'], ['csrf']);
            }
        });
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

        Arr::macro('undot', function ($array) {

            foreach ($array as $key => $value) {

                if (!strpos($key, '.')) {
                    continue;
                }

                Arr::set($array, $key, $value);

                // Trash the old key.
                unset($array[$key]);
            }

            return $array;
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
            return (new HTMLPurifier)->purify($value);
        });

        Str::macro('linkify', function ($text, array $options = []) {
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
            return app(Engine::class)->render($target, array_merge(app('streams.parser_data'), Arr::make($data)));
        });

        Str::macro('markdown', function ($target) {
            return (new \Parsedown)->parse($target);
        });
    }
}
