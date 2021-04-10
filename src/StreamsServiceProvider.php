<?php

namespace Streams\Core;

use HTMLPurifier;
use Misd\Linkify\Linkify;
use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Streams\Core\Entry\Entry;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Streams\Core\View\ViewIncludes;
use Streams\Core\View\ViewTemplate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\View\ViewOverrides;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Addons;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Facades\Integrator;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Streams\Core\Support\Facades\Applications;

class StreamsServiceProvider extends ServiceProvider
{

    /**
     * The class aliases.
     *
     * @var array
     */
    public $aliases = [
        'Assets'      => \Streams\Core\Support\Facades\Assets::class,
        'Images'      => \Streams\Core\Support\Facades\Images::class,
        'Streams'     => \Streams\Core\Support\Facades\Streams::class,
        'Includes'    => \Streams\Core\Support\Facades\Includes::class,
        'Messages'    => \Streams\Core\Support\Facades\Messages::class,
        'Applications' => \Streams\Core\Support\Facades\Applications::class,
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    public $singletons = [
        'addons' => \Streams\Core\Addon\AddonManager::class,
        'assets' => \Streams\Core\Asset\AssetManager::class,
        'images' => \Streams\Core\Image\ImageManager::class,
        'includes' => \Streams\Core\View\ViewIncludes::class,
        'streams' => \Streams\Core\Stream\StreamManager::class,
        'messages' => \Streams\Core\Message\MessageManager::class,
        'applications' => \Streams\Core\Application\ApplicationManager::class,

        'locator'   => \Streams\Core\Support\Locator::class,
        'resolver'  => \Streams\Core\Support\Resolver::class,
        'hydrator'  => \Streams\Core\Support\Hydrator::class,
        'decorator' => \Streams\Core\Support\Decorator::class,
        'evaluator' => \Streams\Core\Support\Evaluator::class,
        'integrator' => \Streams\Core\Support\Integrator::class,
        'transformer' => \Streams\Core\Support\Transformer::class,

        ViewOverrides::class => \Streams\Core\View\ViewOverrides::class,
    ];

    /**
     * The regular bindings.
     *
     * @var array
     */
    public $bindings = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->registerComposerJson();
        $this->registerComposerLock();
        $this->registerFieldTypes();

        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->registerAliases();

        $this->extendUrlGenerator();
        $this->extendCollection();
        $this->extendRequest();
        $this->extendRouter();
        $this->extendLang();
        $this->extendView();
        $this->extendArr();
        $this->extendStr();

        $this->registerStreams();

        $this->registerApplications();
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/streams/core/resources/public')
            => public_path('vendor/streams/core')
        ], ['public']);

        $this->app->singleton('streams.parser_data', function () {

            $parsed = parse_url(Request::url());

            $data = [
                'request' => [
                    'url'      => Request::url(),
                    'path'     => Request::path(),
                    'root'     => Request::root(),
                    'input'    => Request::input(),
                    'full_url' => Request::fullUrl(),
                    'segments' => Request::segments(),
                    'uri'      => Request::getRequestUri(),
                    'query'    => Request::getQueryString(),
                    'parsed'   => array_merge($parsed, [
                        'domain' => explode('.', $parsed['host'])
                    ]),
                ],
                'url' => [
                    'previous' => URL::previous(),
                ],
            ];

            if ($route = Request::route()) {

                $data['route'] = [
                    'uri'                      => $route->uri(),
                    'parameters'               => $route->parameters(),
                    'parameters.to_urlencoded' => array_map(
                        function ($parameter) {
                            return urlencode($parameter);
                        },
                        array_filter($route->parameters())
                    ),
                    'parameter_names'          => $route->parameterNames(),
                    'compiled'                 => [
                        'static_prefix'     => $route->getCompiled()->getStaticPrefix(),
                        'parameters_suffix' => str_replace(
                            $route->getCompiled()->getStaticPrefix(),
                            '',
                            Request::getRequestUri()
                        ),
                    ],
                ];

                // Alias this key variable.
                $data['route']['prefix'] = $data['route']['compiled']['static_prefix'];
            }

            return $data;
        });

        $this->bootApplication();

        // Setup and preparing utilities.
        $this->registerAddons();
        $this->addAssets();
        $this->addImageNamespaces();
        $this->addViewNamespaces();
        $this->loadTranslations();
        // $this->extendLang();
        // $this->extendView();
        // $this->extendArr();
        // $this->extendStr();

        /**
         * Register core commands.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([

                // Asset Commands
                // \Streams\Core\Asset\Console\AssetsClear::class,
                // \Streams\Core\Asset\Console\AssetsPublish::class,

                // Addon Commands
                //\Streams\Core\Addon\Console\AddonPublish::class,
            ]);
        }
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
     * Register the applications.
     */
    protected function registerApplications()
    {
        $url = Request::fullUrl();
        $applications = Applications::collection();

        /**
         * Mark the active application
         * according to it's match.
         */
        $active = $applications->first(function ($application) use ($url) {
            return ($application->match
                && Str::is($application->match, $url));
        });

        if (!$active) {
            $active = $applications->first(function ($application) {
                return !$application->match;
            });
        }

        if (!$active) {
            
            $active = Streams::repository('core.applications')->newInstance([
                'id' => 'default',
                'handle' => 'default',
                'match' => '*',
            ]);
            
            Applications::collection()->put('default', $active);
        }
        
        if ($active) {
            Applications::active($active);
        }
    }

    /**
     * Register the applications.
     */
    protected function bootApplication()
    {
        // Register the active application.
        $active = Applications::active();

        //Transformer::transform($active);
        Integrator::integrate(array_filter([
            'locale' => $active->locale,
            'config' => $active->config,
            'aliases' => $active->aliases,
            'streams' => $active->streams,
            'bindings' => $active->bindings,
            'singletons' => $active->singletons,
        ]));
    }

    /**
     * Register the field types.
     * @todo Finish up
     */
    protected function registerFieldTypes()
    {
        foreach (Config::get('streams.core.field_types', []) as $type => $class) {
            $this->app->bind('streams.core.field_type.' . $type, $class);
        }
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
        $this->mergeConfigFrom(__DIR__ . '/../resources/config/core.php', 'streams.core');

        if (file_exists($config = __DIR__ . '/../../../../config/streams/core.php')) {
            $this->mergeConfigFrom($config, 'streams');
        }

        $this->publishes([
            __DIR__ . '/../resources/config/core.php' => config_path('streams/core.php')
        ], 'config');
    }

    /**
     * Register UI streams.
     */
    protected function registerStreams()
    {
        $prefix = __DIR__ . '/../resources/streams/';
        $streams = ['core.streams', 'core.applications'];

        foreach ($streams as $stream) {
            if (!Streams::has($stream)) {
                Streams::load($prefix . $stream . '.json');
            }
        }

        $this->publishes([
            __DIR__ . '/../resources/streams/' => base_path('streams/')
        ], 'streams');


        /**
         * Register stream configurations.
         */
        $streams = Streams::repository('core.streams')->all();
        $base = $streams->where('extends', null);
        $extending = $streams->where('extends', '!=', null);

        foreach ((new Collection)->merge($base)->merge($extending) as $stream) {

            $stream->handle = $stream->id;

            $stream = Streams::register(Arr::parse($stream->toArray()));

            if (!$this->app->routesAreCached()) {

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

                    if (Arr::pull($route, 'defer')) {

                        $this->app->booted(function () use ($route) {
                            Route::streams(Arr::get($route, 'uri'), $route);
                        });

                        continue;
                    }

                    Route::streams(Arr::get($route, 'uri'), $route);
                }
            }
        }
    }

    /**
     * Register addons.
     */
    protected function registerAddons()
    {
        $lock = json_decode(file_get_contents(base_path('composer.lock')), true);

        $addons = array_filter(
            array_merge($lock['packages'], $lock['packages-dev']),
            function (array $package) {
                return Arr::get($package, 'type') == 'streams-addon';
            }
        );

        ksort($addons);

        $addons = array_map(function ($addon) {
            $addon = Addons::load(base_path('vendor/' . $addon['name']));
        }, $addons);
    }

    /**
     * Add the asset namespace hints.
     */
    protected function addAssets()
    {
        Assets::addPath('public', public_path());
        Assets::addPath('resources', resource_path());

        Assets::addPath('core', 'vendor/streams/core');

        //Assets::add('scripts', '/vendor/streams-vendors.js'); // No
        //Assets::register('core::vendor/axios.js'); // Yes
        Assets::register('core::js/core.js');
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
        View::addNamespace('streams-core', base_path('vendor/streams/core/resources/views'));
        View::addNamespace('storage', storage_path('streams'));
    }

    /**
     * Load translations.
     */
    public function loadTranslations()
    {
        Lang::addNamespace('streams-core', base_path('vendor/streams/core/resources/lang'));
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
        //
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
            $verb        = Arr::pull($route, 'verb', 'any');
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
            $route = Route::{$verb}($uri, $route); // includes Single action controllers
            // if (str_contains($route['uses'], '@')) {
            //     $route = Route::{$verb}($uri, $route);
            // } else {
            //     $route = Route::resource($uri, $route['uses']); // Need flag
            // }

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
                    /** @noinspection SuspiciousLoopInspection */
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

        Blade::directive('lsCache', function ($expression) {

            $parameters = eval("return [$expression];");

            $view = array_shift($parameters);
            $ttl = array_shift($parameters);
            $payload = array_shift($parameters) ?: [];

            return Cache::remember('blade_directive.' . $view, $ttl, function () use ($view, $payload) {
                return (string) View::make($view, $payload);
            });
        });

        Blade::directive('lsBindCache', function ($expression) {

            $parameters = eval("return [$expression];");

            $stream = array_shift($parameters);
            $view = array_shift($parameters);
            $ttl = array_shift($parameters);
            $payload = array_shift($parameters) ?: [];

            return Streams::make($stream)->cache('blade_directive.' . $view, $ttl, function () use ($view, $payload) {
                return (string) View::make($view, $payload);
            });
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

        Arr::macro('htmlAttributes', function ($attributes) {
            return HtmlFacade::attributes($attributes);
        });

        Arr::macro('export', function ($expression, $return = false) {

            $export = var_export($expression, TRUE);
            $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
            $array = preg_split("/\r\n|\n|\r/", $export);
            $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [NULL, ']$1', ' => ['], $array);
            $export = join(PHP_EOL, array_filter(["["] + $array));

            if ((bool)$return) {
                return $export;
            }

            echo $export;
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

            $default = App::has('streams.parser_data') ? App::make('streams.parser_data') : [];

            return app(Engine::class)->render($target, array_filter(array_merge($default, [
                'app' => [
                    'locale' => App::getLocale(),
                ],
            ], Arr::make($data))));
        });

        Str::macro('markdown', function ($target) {
            return (new \Parsedown)->parse($target);
        });
    }
}
