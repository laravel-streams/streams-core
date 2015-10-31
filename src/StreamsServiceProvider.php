<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Anomaly\Streams\Platform\Application\Command\ConfigureCommandBus;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Anomaly\Streams\Platform\Application\Command\LoadStreamsConfiguration;
use Anomaly\Streams\Platform\Application\Command\SetCoreConnection;
use Anomaly\Streams\Platform\Asset\Command\AddAssetNamespaces;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\AssignmentObserver;
use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModels;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Event\Booted;
use Anomaly\Streams\Platform\Event\Booting;
use Anomaly\Streams\Platform\Event\Ready;
use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Field\FieldObserver;
use Anomaly\Streams\Platform\Image\Command\AddImageNamespaces;
use Anomaly\Streams\Platform\Lang\Loader;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Stream\StreamObserver;
use Anomaly\Streams\Platform\View\Command\AddViewNamespaces;
use Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins;
use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;

/**
 * Class StreamsServiceProvider
 *
 * In order to consolidate service providers throughout the
 * Streams Platform, we do all of our bootstrapping here.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform
 */
class StreamsServiceProvider extends ServiceProvider
{

    use DispatchesJobs;

    /**
     * The providers to register.
     *
     * @var array
     */
    protected $providers = [
        'Anomaly\Streams\Platform\StreamsConsoleProvider',
        'Anomaly\Streams\Platform\StreamsEventProvider'
    ];

    /**
     * The plugins to register.
     *
     * @var array
     */
    protected $plugins = [
        'Phive\Twig\Extensions\Deferred\DeferredExtension',
        'TwigBridge\Extension\Laravel\Form',
        'TwigBridge\Extension\Laravel\Html',
        'Anomaly\Streams\Platform\Ui\UiPlugin',
        'Anomaly\Streams\Platform\StreamsPlugin',
        'Anomaly\Streams\Platform\Agent\AgentPlugin',
        'Anomaly\Streams\Platform\Asset\AssetPlugin',
        'Anomaly\Streams\Platform\Image\ImagePlugin',
        'Anomaly\Streams\Platform\Message\MessagePlugin',
        'Anomaly\Streams\Platform\Application\ApplicationPlugin'
    ];

    /**
     * The commands to register.
     *
     * @var array
     */
    protected $commands = [
        'Anomaly\Streams\Platform\Asset\Console\Clear',
        'Anomaly\Streams\Platform\Stream\Console\Compile',
        'Anomaly\Streams\Platform\Stream\Console\Refresh',
        'Anomaly\Streams\Platform\Stream\Console\Cleanup',
        'Anomaly\Streams\Platform\Stream\Console\Destroy',
        'Anomaly\Streams\Platform\Stream\Console\MakeEntity',
        'Anomaly\Streams\Platform\Addon\Console\MakeAddon',
        'Anomaly\Streams\Platform\Addon\Console\CacheAddons',
        'Anomaly\Streams\Platform\Addon\Console\ClearAddons',
        'Anomaly\Streams\Platform\Addon\Module\Console\Install',
        'Anomaly\Streams\Platform\Addon\Module\Console\Uninstall',
        'Anomaly\Streams\Platform\Addon\Module\Console\Reinstall',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Install',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Uninstall',
        'Anomaly\Streams\Platform\Addon\Extension\Console\Reinstall',
        'Anomaly\Streams\Platform\Application\Console\EnvSet'
    ];

    /**
     * The class bindings.
     *
     * @var array
     */
    protected $bindings = [
        'Illuminate\Contracts\Debug\ExceptionHandler'                                    => 'Anomaly\Streams\Platform\Exception\ExceptionHandler',
        'Anomaly\Streams\Platform\Entry\EntryModel'                                      => 'Anomaly\Streams\Platform\Entry\EntryModel',
        'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface'               => 'Anomaly\Streams\Platform\Entry\EntryRepository',
        'Anomaly\Streams\Platform\Field\FieldModel'                                      => 'Anomaly\Streams\Platform\Field\FieldModel',
        'Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface'               => 'Anomaly\Streams\Platform\Field\FieldRepository',
        'Anomaly\Streams\Platform\Stream\StreamModel'                                    => 'Anomaly\Streams\Platform\Stream\StreamModel',
        'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface'             => 'Anomaly\Streams\Platform\Stream\StreamRepository',
        'Anomaly\Streams\Platform\Assignment\AssignmentModel'                            => 'Anomaly\Streams\Platform\Assignment\AssignmentModel',
        'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface'     => 'Anomaly\Streams\Platform\Assignment\AssignmentRepository',
        'Anomaly\Streams\Platform\Addon\Module\ModuleModel'                              => 'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
        'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface'       => 'Anomaly\Streams\Platform\Addon\Module\ModuleRepository',
        'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel'                        => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel',
        'Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface' => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionRepository',
        'addon.collection'                                                               => 'Anomaly\Streams\Platform\Addon\AddonCollection',
        'module.collection'                                                              => 'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
        'extension.collection'                                                           => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
        'field_type.collection'                                                          => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',
        'plugin.collection'                                                              => 'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
        'theme.collection'                                                               => 'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'
    ];

    /**
     * The singleton bindings.
     *
     * @var array
     */
    protected $singletons = [
        'Robbo\Presenter\Decorator'                                                    => 'Robbo\Presenter\Decorator',
        'League\Flysystem\MountManager'                                                => 'League\Flysystem\MountManager',
        'Illuminate\Console\Scheduling\Schedule'                                       => 'Illuminate\Console\Scheduling\Schedule',
        'Anomaly\Streams\Platform\Application\Application'                             => 'Anomaly\Streams\Platform\Application\Application',
        'Anomaly\Streams\Platform\Addon\AddonLoader'                                   => 'Anomaly\Streams\Platform\Addon\AddonLoader',
        'Anomaly\Streams\Platform\Addon\AddonBinder'                                   => 'Anomaly\Streams\Platform\Addon\AddonBinder',
        'Anomaly\Streams\Platform\Addon\AddonManager'                                  => 'Anomaly\Streams\Platform\Addon\AddonManager',
        'Anomaly\Streams\Platform\Addon\AddonCollection'                               => 'Anomaly\Streams\Platform\Addon\AddonCollection',
        'Anomaly\Streams\Platform\Message\MessageBag'                                  => 'Anomaly\Streams\Platform\Message\MessageBag',
        'Anomaly\Streams\Platform\Stream\StreamStore'                                  => 'Anomaly\Streams\Platform\Stream\StreamStore',
        'Anomaly\Streams\Platform\Support\Configurator'                                => 'Anomaly\Streams\Platform\Support\Configurator',
        'Anomaly\Streams\Platform\Support\Authorizer'                                  => 'Anomaly\Streams\Platform\Support\Authorizer',
        'Anomaly\Streams\Platform\Support\Evaluator'                                   => 'Anomaly\Streams\Platform\Support\Evaluator',
        'Anomaly\Streams\Platform\Support\Parser'                                      => 'Anomaly\Streams\Platform\Support\Parser',
        'Anomaly\Streams\Platform\Support\Hydrator'                                    => 'Anomaly\Streams\Platform\Support\Hydrator',
        'Anomaly\Streams\Platform\Support\Resolver'                                    => 'Anomaly\Streams\Platform\Support\Resolver',
        'Anomaly\Streams\Platform\Support\Translator'                                  => 'Anomaly\Streams\Platform\Support\Translator',
        'Anomaly\Streams\Platform\Asset\Asset'                                         => 'Anomaly\Streams\Platform\Asset\Asset',
        'Anomaly\Streams\Platform\Asset\AssetPaths'                                    => 'Anomaly\Streams\Platform\Asset\AssetPaths',
        'Anomaly\Streams\Platform\Asset\AssetParser'                                   => 'Anomaly\Streams\Platform\Asset\AssetParser',
        'Anomaly\Streams\Platform\Image\Image'                                         => 'Anomaly\Streams\Platform\Image\Image',
        'Anomaly\Streams\Platform\Image\ImagePaths'                                    => 'Anomaly\Streams\Platform\Image\ImagePaths',
        'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry'                => 'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry',
        'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry'            => 'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry',
        'Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection'                  => 'Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection',
        'Anomaly\Streams\Platform\Ui\Icon\IconRegistry'                                => 'Anomaly\Streams\Platform\Ui\Icon\IconRegistry',
        'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry'                            => 'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry',
        'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection' => 'Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\SectionCollection',
        'Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection'                => 'Anomaly\Streams\Platform\Http\Middleware\MiddlewareCollection',
        'Anomaly\Streams\Platform\Stream\StreamModel'                                  => 'Anomaly\Streams\Platform\Stream\StreamModel',
        'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'                       => 'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
        'Anomaly\Streams\Platform\Addon\Module\Listener\PutModuleInCollection'         => 'Anomaly\Streams\Platform\Addon\Module\Listener\PutModuleInCollection',
        'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection'                 => 'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
        'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection'   => 'Anomaly\Streams\Platform\Addon\Extension\Listener\PutExtensionInCollection',
        'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor'                   => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAccessor',
        'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier'                   => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeModifier',
        'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection'                 => 'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',
        'Anomaly\Streams\Platform\Addon\FieldType\Listener\PutFieldTypeInCollection'   => 'Anomaly\Streams\Platform\Addon\FieldType\Listener\PutFieldTypeInCollection',
        'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection'                       => 'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
        'Anomaly\Streams\Platform\Addon\Plugin\Listener\AddPluginToTwig'               => 'Anomaly\Streams\Platform\Addon\Plugin\Listener\AddPluginToTwig',
        'Anomaly\Streams\Platform\Addon\Plugin\Listener\PutPluginInCollection'         => 'Anomaly\Streams\Platform\Addon\Plugin\Listener\PutPluginInCollection',
        'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'                         => 'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection',
        'Anomaly\Streams\Platform\Addon\Theme\Listener\PutThemeInCollection'           => 'Anomaly\Streams\Platform\Addon\Theme\Listener\PutThemeInCollection',
        'Anomaly\Streams\Platform\View\ViewComposer'                                   => 'Anomaly\Streams\Platform\View\ViewComposer',
        'Anomaly\Streams\Platform\View\ViewTemplate'                                   => 'Anomaly\Streams\Platform\View\ViewTemplate',
        'Anomaly\Streams\Platform\View\ViewOverrides'                                  => 'Anomaly\Streams\Platform\View\ViewOverrides',
        'Anomaly\Streams\Platform\View\ViewMobileOverrides'                            => 'Anomaly\Streams\Platform\View\ViewMobileOverrides',
        'Anomaly\Streams\Platform\View\Listener\LoadTemplateData'                      => 'Anomaly\Streams\Platform\View\Listener\LoadTemplateData',
        'Anomaly\Streams\Platform\View\Listener\DecorateData'                          => 'Anomaly\Streams\Platform\View\Listener\DecorateData',
        'Anomaly\Streams\Platform\Support\String'                                      => 'Anomaly\Streams\Platform\Support\String'
    ];

    /**
     * Boot the service provider.
     */
    public function boot(Dispatcher $events)
    {
        $events->fire(new Booting());

        $this->dispatch(new SetCoreConnection());
        $this->dispatch(new ConfigureCommandBus());
        $this->dispatch(new ConfigureTranslator());
        $this->dispatch(new LoadStreamsConfiguration());

        $this->dispatch(new InitializeApplication());
        $this->dispatch(new AutoloadEntryModels());
        $this->dispatch(new AddAssetNamespaces());
        $this->dispatch(new AddImageNamespaces());
        $this->dispatch(new AddViewNamespaces());

        EntryModel::observe(EntryObserver::class);
        FieldModel::observe(FieldObserver::class);
        StreamModel::observe(StreamObserver::class);
        EloquentModel::observe(EloquentObserver::class);
        AssignmentModel::observe(AssignmentObserver::class);

        $this->app->booted(
            function () use ($events) {

                $events->fire(new Booted());

                /* @var AddonManager $manager */
                $manager = $this->app->make('Anomaly\Streams\Platform\Addon\AddonManager');

                /* @var Dispatcher $events */
                $events = $this->app->make('Illuminate\Contracts\Events\Dispatcher');

                $events->listen(
                    'Anomaly\Streams\Platform\View\Event\RegisteringTwigPlugins',
                    function (RegisteringTwigPlugins $event) {

                        $twig = $event->getTwig();

                        foreach ($this->plugins as $plugin) {
                            $twig->addExtension($this->app->make($plugin));
                        }

                        $twig->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));
                    }
                );

                $manager->register();

                $events->fire(new Ready());
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
         * Register all third party packages first.
         */
        $this->app->register('TwigBridge\ServiceProvider');
        $this->app->register('Barryvdh\HttpCache\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');

        if (env('APP_DEBUG')) {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }

        // Register bindings.
        foreach ($this->bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }

        // Register singletons.
        foreach ($this->singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        // Register streams other providers.
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }

        // Register commands.
        $this->commands($this->commands);

        /**
         * Change the default language path so
         * that there MUST be a prefix hint.
         */
        $this->app->singleton(
            'path.lang',
            function () {
                return realpath(__DIR__ . '/../resources/lang');
            }
        );

        /**
         * Register the path to the streams platform.
         * This is handy for helping load other streams things.
         */
        $this->app->instance(
            'streams.path',
            $this->app->make('path.base') . '/vendor/anomaly/streams-platform'
        );

        /**
         * If we don't have an .env file we need to head
         * to the installer (unless that's where we're at).
         */
        if (!env('INSTALLED') && $this->app->make('request')->segment(1) !== 'installer') {

            $this->app->make('router')->any(
                '{url?}',
                function (Redirector $redirector) {
                    return $redirector->to('installer');
                }
            )->where(['url' => '(.*)']);

            return;
        }

        /**
         * Register form handler route.
         */
        $this->app->make('router')->post(
            'form/handle/{key}',
            'Anomaly\Streams\Platform\Http\Controller\FormController@handle'
        );
    }
}
