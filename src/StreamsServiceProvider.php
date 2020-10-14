<?php

namespace Streams\Core;

use HTMLPurifier;
use Misd\Linkify\Linkify;
use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Streams\Core\Addon\Addon;
use Illuminate\Support\Collection;
use Streams\Core\View\ViewIncludes;
use Streams\Core\View\ViewTemplate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;
use Streams\Core\Addon\AddonCollection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
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
        'Assets' => \Streams\Core\Support\Facades\Assets::class,
        'Images' => \Streams\Core\Support\Facades\Images::class,
        'Streams' => \Streams\Core\Support\Facades\Streams::class,
        'Includes' => \Streams\Core\Support\Facades\Includes::class,
        'Messages' => \Streams\Core\Support\Facades\Messages::class,
        'Application' => \Streams\Core\Support\Facades\Application::class,
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    public $bindings = [
        'streams.addons'      => \Streams\Core\Addon\AddonCollection::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        'assets' => \Streams\Core\Asset\AssetManager::class,
        'images' => \Streams\Core\Image\ImageManager::class,
        'includes' => \Streams\Core\View\ViewIncludes::class,
        'streams' => \Streams\Core\Stream\StreamManager::class,
        ViewOverrides::class => \Streams\Core\View\ViewOverrides::class,
        'messages' => \Streams\Core\Message\MessageManager::class,
        'applications' => \Streams\Core\Application\ApplicationManager::class,

        'locator' => \Streams\Core\Support\Locator::class,
        'resolver' => \Streams\Core\Support\Resolver::class,
        'hydrator' => \Streams\Core\Support\Hydrator::class,
        'decorator' => \Streams\Core\Support\Decorator::class,
        'evaluator' => \Streams\Core\Support\Evaluator::class,
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
        $this->extendRequest();
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
                \Streams\Core\Asset\Console\AssetsClear::class,
                \Streams\Core\Asset\Console\AssetsPublish::class,

                // Addon Commands
                //\Streams\Core\Addon\Console\AddonPublish::class,
            ]);
        }

        /**
         * Register publishables.
         */
        $this->publishes([
            base_path('vendor/streams/core/docs') => base_path(
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
        $this->app->bind('streams.field_types.url', \Streams\Core\Field\Type\Url::class);
        $this->app->bind('streams.field_types.text', \Streams\Core\Field\Type\Text::class);
        $this->app->bind('streams.field_types.slug', \Streams\Core\Field\Type\Slug::class);
        $this->app->bind('streams.field_types.string', \Streams\Core\Field\Type\Text::class);
        $this->app->bind('streams.field_types.textarea', \Streams\Core\Field\Type\Text::class);
        $this->app->bind('streams.field_types.markdown', \Streams\Core\Field\Type\Markdown::class);
        $this->app->bind('streams.field_types.template', \Streams\Core\Field\Type\Template::class);

        // Array
        $this->app->bind('streams.field_types.array', \Streams\Core\Field\Type\Arr::class);

        // Integers
        $this->app->bind('streams.field_types.int', \Streams\Core\Field\Type\Integer::class);
        $this->app->bind('streams.field_types.integer', \Streams\Core\Field\Type\Integer::class);

        // Decimals
        $this->app->bind('streams.field_types.float', \Streams\Core\Field\Type\Decimal::class);
        $this->app->bind('streams.field_types.double', \Streams\Core\Field\Type\Decimal::class);
        $this->app->bind('streams.field_types.decimal', \Streams\Core\Field\Type\Decimal::class);

        // Boolean
        $this->app->bind('streams.field_types.bool', \Streams\Core\Field\Type\Boolean::class);
        $this->app->bind('streams.field_types.boolean', \Streams\Core\Field\Type\Boolean::class);

        // Selections
        $this->app->bind('streams.field_types.select', \Streams\Core\Field\Type\Select::class);

        // Dates
        $this->app->bind('streams.field_types.date', \Streams\Core\Field\Type\Date::class);
        $this->app->bind('streams.field_types.time', \Streams\Core\Field\Type\Time::class);
        $this->app->bind('streams.field_types.datetime', \Streams\Core\Field\Type\Datetime::class);

        // Assets
        //$this->app->bind('streams.field_types.asset', \Streams\Core\Field\Type\Asset::class);
        $this->app->bind('streams.field_types.image', \Streams\Core\Field\Type\Image::class);

        // Objects
        //$this->app->bind('streams.field_types.object', \Streams\Core\Field\Type\Object::class);
        $this->app->bind('streams.field_types.collection', \Streams\Core\Field\Type\Collection::class);

        // Streams
        $this->app->bind('streams.field_types.entry', \Streams\Core\Field\Type\Entry::class);
        $this->app->bind('streams.field_types.entries', \Streams\Core\Field\Type\Entries::class);

        // Relationships
        $this->app->bind('streams.field_types.multiple', \Streams\Core\Field\Type\Multiple::class);
        $this->app->bind('streams.field_types.polymorphic', \Streams\Core\Field\Type\Polymorphic::class);
        $this->app->bind('streams.field_types.relationship', \Streams\Core\Field\Type\Relationship::class);

        // Miscellaneous
        $this->app->bind('streams.field_types.color', \Streams\Core\Field\Type\Color::class);
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
        View::addNamespace('streams', base_path('vendor/streams/core/resources/views'));
        View::addNamespace('storage', storage_path('streams'));
    }

    /**
     * Load translations.
     */
    public function loadTranslations()
    {
        Lang::addNamespace('streams', base_path('vendor/streams/core/resources/lang'));
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
     * Extend the request.
     */
    protected function extendRequest()
    {
        Request::macro('isLocal', function () {
            return in_array(Request::ip(), ['127.0.0.1', '::1']);
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
                    'uses' => '\Streams\Core\Http\Controller\StreamsController@handle',
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
                $route['uses'] = '\Streams\Core\Http\Controller\StreamsController@handle';
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

        Factory::macro('override', function ($view, $override) {
            return app(ViewOverrides::class)->put($view, $override);
        });

        View::composer('*', function ($view) {
            if ($override = app(ViewOverrides::class)->get($view->name())) {
                $view->setPath(base_path($override));
            }
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

            if (!strpos($target, '}')) {
                return $target;
            }

            return app(Engine::class)->render($target, array_merge(app('streams.parser_data'), Arr::make($data)));
        });

        Str::macro('markdown', function ($target) {
            return (new \Parsedown)->parse($target);
        });
    }
}
