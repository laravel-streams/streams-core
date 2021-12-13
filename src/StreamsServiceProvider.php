<?php

namespace Streams\Core;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Illuminate\View\Factory;
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use Streams\Core\Application\Application;
use Streams\Core\Support\ComposerScripts;
use Streams\Core\Support\Facades\Addons;
use Streams\Core\Support\Facades\Applications;
use Streams\Core\Support\Facades\Assets;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Support\Facades\Integrator;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Macros\ArrExport;
use Streams\Core\Support\Macros\ArrHtmlAttributes;
use Streams\Core\Support\Macros\ArrMake;
use Streams\Core\Support\Macros\ArrParse;
use Streams\Core\Support\Macros\ArrUndot;
use Streams\Core\Support\Macros\CollectionHasAny;
use Streams\Core\Support\Macros\FactoryInclude;
use Streams\Core\Support\Macros\FactoryIncludes;
use Streams\Core\Support\Macros\FactoryOverride;
use Streams\Core\Support\Macros\FactoryParse;
use Streams\Core\Support\Macros\RouteStreams;
use Streams\Core\Support\Macros\StrHumanize;
use Streams\Core\Support\Macros\StrIsSerialized;
use Streams\Core\Support\Macros\StrLinkify;
use Streams\Core\Support\Macros\StrMarkdown;
use Streams\Core\Support\Macros\StrParse;
use Streams\Core\Support\Macros\StrPurify;
use Streams\Core\Support\Macros\StrTruncate;
use Streams\Core\Support\Macros\TranslatorTranslate;
use Streams\Core\Support\Macros\UrlStreams;
use Streams\Core\Support\Markdown\StreamsMarkdownExtension;
use Streams\Core\Support\Parser;
use Streams\Core\View\ViewOverrides;

class StreamsServiceProvider extends ServiceProvider
{

    public $aliases = [
        'Assets'       => \Streams\Core\Support\Facades\Assets::class,
        'Images'       => \Streams\Core\Support\Facades\Images::class,
        'Streams'      => \Streams\Core\Support\Facades\Streams::class,
        'Includes'     => \Streams\Core\Support\Facades\Includes::class,
        'Messages'     => \Streams\Core\Support\Facades\Messages::class,
        'Applications' => \Streams\Core\Support\Facades\Applications::class,
    ];

    public $singletons = [
        'addons'       => \Streams\Core\Addon\AddonManager::class,
        'assets'       => \Streams\Core\Asset\AssetManager::class,
        'images'       => \Streams\Core\Image\ImageManager::class,
        'includes'     => \Streams\Core\View\ViewIncludes::class,
        'streams'      => \Streams\Core\Stream\StreamManager::class,
        'messages'     => \Streams\Core\Message\MessageManager::class,
        'applications' => \Streams\Core\Application\ApplicationManager::class,

        'hydrator'   => \Streams\Core\Support\Hydrator::class,
        'decorator'  => \Streams\Core\Support\Decorator::class,
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
        $this->registerMacros();
        $this->extendView();
        $this->extendApp();
        $this->registerMarkdown();

        $this->publishes([
            dirname(__DIR__) . '/resources/public'
            => public_path('vendor/streams/core'),
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
        $url          = Request::fullUrl();
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
                'stream' => Streams::make('core.applications'),
                'id'    => 'default',
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
            'locale'     => $active->locale,
            'config'     => $active->config,
            'aliases'    => $active->aliases,
            'streams'    => $active->streams,
            'bindings'   => $active->bindings,
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
            __DIR__ . '/../resources/config/core.php' => config_path('streams/core.php'),
        ], 'config');
    }

    /**
     * Register UI streams.
     */
    protected function registerStreams()
    {
        $prefix  = dirname(__DIR__) . '/resources/streams/';
        $streams = ['core.streams', 'core.applications'];

        foreach ($streams as $stream) {
            if (!Streams::exists($stream)) {
                Streams::load($prefix . $stream . '.json');
            }
        }

        $this->publishes([
            dirname(__DIR__) . '/resources/streams/' => base_path('streams/'),
        ], 'streams');

        /**
         * Register stream configurations.
         */
        $streams = Streams::repository('core.streams')->all();

        /**
         * Defer registering streams that extend others.
         */
        $base      = $streams->where('extends', null)->keyBy('id');
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
        if ($this->app['composer.generated'] === false) {
            $lock       = json_decode(file_get_contents(base_path('composer.lock')), true);
            $vendorPath = base_path('vendor');
            $addons     = array_filter(
                array_merge($lock['packages'], $lock['packages-dev']),
                function (array $package) {
                    return Arr::get($package, 'type') === 'streams-addon';
                }
            );
        } else {
            $addons     = $this->app['composer.generated']['addons'];
            $vendorPath = $this->app['composer.generated']['vendorPath'];
        }
        
        ksort($addons);

        $addons = array_map(function ($addon) use ($vendorPath) {
            $addon = Addons::load($vendorPath . '/' . $addon['name']);
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
        Lang::addNamespace('streams', dirname(__DIR__) . '/resources/lang');
    }

    /**
     * Extend the view system.
     */
    protected function extendView()
    {

        // @todo move this to booted/event that loops and overrides instead of decorating all?
        View::composer('*', function ($view) {
            if ($override = app(ViewOverrides::class)->get($view->name())) {
                $view->setPath(base_path($override));
            }
        });

        Blade::directive('lsCache', function ($expression) {

            $parameters = eval("return [$expression];");

            $view    = array_shift($parameters);
            $ttl     = array_shift($parameters);
            $payload = array_shift($parameters) ?: [];

            return Cache::remember('blade_directive.' . $view, $ttl, function () use ($view, $payload) {
                return (string)View::make($view, $payload);
            });
        });

        Blade::directive('lsBindCache', function ($expression) {

            $parameters = eval("return [$expression];");

            $stream  = array_shift($parameters);
            $view    = array_shift($parameters);
            $ttl     = array_shift($parameters);
            $payload = array_shift($parameters) ?: [];

            return Streams::make($stream)->cache('blade_directive.' . $view, $ttl, function () use ($view, $payload) {
                return (string)View::make($view, $payload);
            });
        });
    }

    protected function registerMacros()
    {
        Arr::macro('htmlAttributes', $this->app[ArrHtmlAttributes::class]());
        Arr::macro('make', $this->app[ArrMake::class]());
        Arr::macro('undot', $this->app[ArrUndot::class]());
        Arr::macro('parse', $this->app[ArrParse::class]());
        Arr::macro('export', $this->app[ArrExport::class]());
        Collection::macro('hasAny', $this->app[CollectionHasAny::class]());
        Factory::macro('parse', $this->app[FactoryParse::class]());
        Factory::macro('include', $this->app[FactoryInclude::class]());
        Factory::macro('includes', $this->app[FactoryIncludes::class]());
        Factory::macro('override', $this->app[FactoryOverride::class]());
        Route::macro('streams', $this->app[RouteStreams::class]());
        URL::macro('streams', $this->app[UrlStreams::class]());
        Str::macro('parse', $this->app[StrParse::class]());
        Str::macro('humanize', $this->app[StrHumanize::class]());
        Str::macro('truncate', $this->app[StrTruncate::class]());
        Str::macro('isSerialized', $this->app[StrIsSerialized::class]());
        Str::macro('purify', $this->app[StrPurify::class]());
        Str::macro('linkify', $this->app[StrLinkify::class]());
        Str::macro('markdown', $this->app[StrMarkdown::class]());
        Translator::macro('translate', $this->app[TranslatorTranslate::class]());
    }

    protected function registerMarkdown()
    {
        $this->app->singleton(MarkdownConverter::class, function (\Illuminate\Contracts\Foundation\Application $app) {
            $config      = $app['config']['streams.core.markdown'];
            $environment = new Environment($config['configs']);
            foreach ($config['extensions'] as $extension) {
                $environment->addExtension(new $extension());
            }
            return new MarkdownConverter($environment);
        });
    }

    /**
     * Extend the Laravel application.
     */
    protected function extendApp()
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        $path = (string)base_path(Arr::get($composer, 'config.vendor-dir', 'vendor'));

        $this->app['vendor.path'] = $path;
    }
}
