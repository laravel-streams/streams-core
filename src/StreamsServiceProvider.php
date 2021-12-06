<?php

namespace Streams\Core;

use HTMLPurifier;
use Misd\Linkify\Linkify;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\Factory;
use Collective\Html\HtmlFacade;
use Streams\Core\Support\Parser;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Streams\Core\View\ViewTemplate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Streams\Core\View\ViewOverrides;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Streams\Core\Stream\StreamRouter;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Illuminate\Translation\Translator;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\ComposerScripts;
use Illuminate\Support\ServiceProvider;
use Streams\Core\Support\Facades\Addons;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Macros\ArrMacros;
use Streams\Core\Support\Macros\StrMacros;
use Streams\Core\Support\Macros\UrlMacros;
use Streams\Core\Support\Facades\Integrator;
use Streams\Core\Support\Facades\Applications;
use Streams\Core\Support\Macros\FactoryMacros;
use Streams\Core\Support\Macros\TranslatorMacros;

class StreamsServiceProvider extends ServiceProvider
{

    public $aliases = [
        'Assets'      => \Streams\Core\Support\Facades\Assets::class,
        'Images'      => \Streams\Core\Support\Facades\Images::class,
        'Streams'     => \Streams\Core\Support\Facades\Streams::class,
        'Includes'    => \Streams\Core\Support\Facades\Includes::class,
        'Messages'    => \Streams\Core\Support\Facades\Messages::class,
        'Applications' => \Streams\Core\Support\Facades\Applications::class,
    ];

    public $singletons = [
        'addons' => \Streams\Core\Addon\AddonManager::class,
        'assets' => \Streams\Core\Asset\AssetManager::class,
        'images' => \Streams\Core\Image\ImageManager::class,
        'includes' => \Streams\Core\View\ViewIncludes::class,
        'streams' => \Streams\Core\Stream\StreamManager::class,
        'messages' => \Streams\Core\Message\MessageManager::class,
        'applications' => \Streams\Core\Application\ApplicationManager::class,

        'hydrator'  => \Streams\Core\Support\Hydrator::class,
        'decorator' => \Streams\Core\Support\Decorator::class,
        'integrator' => \Streams\Core\Support\Integrator::class,

        ViewOverrides::class => ViewOverrides::class,
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

        $this->registerComposerGenerated();
        $this->registerComposerJson();
        $this->registerComposerLock();
        $this->registerFieldTypes();

        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->app->instance('faker', fn () => \Faker\Factory::create());

        $this->registerAliases();

        $this->extendUrlGenerator();
        $this->extendCollection();
        $this->extendRequest();
        $this->extendRouter();
        $this->extendLang();
        $this->extendView();
        $this->extendArr();
        $this->extendApp();
        $this->extendStr();

        $this->publishes([
            dirname(__DIR__) . '/resources/public'
            => public_path('vendor/streams/core')
        ], ['public']);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->singleton('streams.parser_data', fn () => Parser::data());

        $this->registerStreams();

        $this->registerApplications();

        $this->bootApplication();

        $this->addAssets();
        $this->registerAddons();
        $this->addViewNamespaces();
        $this->addImageNamespaces();
        $this->loadTranslations();

        $this->app->singleton('streams.faker', function () {
            return \Faker\Factory::create();
        });

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

    protected function registerComposerGenerated()
    {
        $this->app->instance('composer.generated', ComposerScripts::getGenerated());
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
            return $application->match && collect((array)$application->match)->filter(function ($match) use ($url) {
                return Str::is($match, $url);
            })->isNotEmpty();
        });

        if (!$active) {
            $active = $applications->first(function ($application) {
                return !$application->match;
            });
        }

        if (!$active) {

            $active = new Application([
                'id' => 'default',
                'match' => '*',
            ]);
        }

        if ($active) {
            Applications::activate($active);
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
        $prefix = dirname(__DIR__)  . '/resources/streams/';
        $streams = ['core.streams', 'core.applications'];

        foreach ($streams as $stream) {
            if (!Streams::exists($stream)) {
                Streams::load($prefix . $stream . '.json');
            }
        }

        $this->publishes([
            dirname(__DIR__)  . '/resources/streams/' => base_path('streams/')
        ], 'streams');

        /**
         * Register stream configurations.
         */
        $streams = Streams::repository('core.streams')->all();

        /**
         * Defer registering streams that extend others.
         */
        $base = $streams->where('extends', null)->keyBy('id');
        $extending = $streams->where('extends', '!=', null)->keyBy('id');

        foreach ((new Collection)->merge($base)->merge($extending) as $stream) {
            Streams::register(Arr::parse($stream->toArray()));
        }
    }

    /**
     * Register addons.
     */
    protected function registerAddons()
    {

        $addons    = $this->app[ 'composer.generated' ][ 'addons' ];
        $vendorPath = $this->app[ 'composer.generated' ][ 'vendorPath' ];
        ksort($addons);

        $addons = array_map(function ($addon) use ($vendorPath) {
            $addon = Addons::load($vendorPath. '/' . $addon[ 'name' ]);
        }, $addons);
    }

    /**
     * Add the asset namespace hints.
     */
    protected function addAssets()
    {
        Assets::addPath('public', public_path());
        Assets::addPath('core', dirname(__DIR__));
        Assets::addPath('resources', resource_path());

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
        Images::addPath('streams', dirname(__DIR__) . '/resources');
    }

    /**
     * Add view namespaces.
     */
    public function addViewNamespaces()
    {
        View::addNamespace('core', dirname(__DIR__) . '/resources/views');
        View::addNamespace('storage', storage_path('streams/' . Applications::active()->id));
    }

    /**
     * Load translations.
     */
    public function loadTranslations()
    {
        Lang::addNamespace('streams',  dirname(__DIR__) . '/resources/lang');
    }

    /**
     * Extend the URL generator.
     */
    protected function extendUrlGenerator()
    {
        URL::macro('streams', [UrlMacros::class, 'streams']);
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
        Route::macro('streams', [StreamRouter::class, 'route']);
    }

    /**
     * Extend the lang system.
     */
    protected function extendLang()
    {
        Translator::macro('translate', [TranslatorMacros::class, 'translate']);
    }

    /**
     * Extend the view system.
     */
    protected function extendView()
    {
        Factory::macro('parse', [ViewTemplate::class, 'make']);

        Factory::macro('include', [FactoryMacros::class, 'include']);
        Factory::macro('includes', [FactoryMacros::class, 'includes']);

        Factory::macro('override', function ($view, $override) {
            return app(ViewOverrides::class)->put($view, $override);
        });

        // @todo move this to booted/event that loops and overrides instead of decorating all?
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
        Arr::macro('htmlAttributes', fn ($attributes) => HtmlFacade::attributes($attributes));

        Arr::macro('make', [ArrMacros::class, 'make']);
        Arr::macro('undot', [ArrMacros::class, 'undot']);
        Arr::macro('parse', [ArrMacros::class, 'parse']);
        Arr::macro('export', [ArrMacros::class, 'export']);
    }

    /**
     * Extend the Laravel application.
     */
    protected function extendApp()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $path = (string) base_path(Arr::get($composer, 'config.vendor-dir', 'vendor'));

        $this->app['vendor.path'] = $path;
    }

    /**
     * Extend the string utility.
     */
    protected function extendStr()
    {
        Str::macro('parse', [StrMacros::class, 'parse']);
        Str::macro('humanize', [StrMacros::class, 'humanize']);
        Str::macro('truncate', [StrMacros::class, 'truncate']);
        Str::macro('isSerialized', [StrMacros::class, 'isSerialized']);

        Str::macro('purify', [HTMLPurifier::class, 'purify']);

        Str::macro('linkify', function ($text, array $options = []) {
            return (new Linkify($options))->process($text);
        });

        Str::macro('markdown', [\Parsedown::class, 'parse']);
    }
}
