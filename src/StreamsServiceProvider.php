<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\Command\RegisterAddons;
use Anomaly\Streams\Platform\Application\Command\AddTwigExtensions;
use Anomaly\Streams\Platform\Application\Command\CheckDirectoryPermissions;
use Anomaly\Streams\Platform\Application\Command\ConfigureCommandBus;
use Anomaly\Streams\Platform\Application\Command\ConfigureTranslator;
use Anomaly\Streams\Platform\Application\Command\InitializeApplication;
use Anomaly\Streams\Platform\Application\Command\LoadStreamsConfiguration;
use Anomaly\Streams\Platform\Application\Command\SetCoreConnection;
use Anomaly\Streams\Platform\Asset\Command\AddAssetNamespaces;
use Anomaly\Streams\Platform\Entry\Command\AutoloadEntryModels;
use Anomaly\Streams\Platform\Image\Command\AddImageNamespaces;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Redirector;
use Illuminate\Support\ServiceProvider;

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

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new SetCoreConnection());
        $this->dispatch(new ConfigureCommandBus());
        $this->dispatch(new ConfigureTranslator());
        $this->dispatch(new LoadStreamsConfiguration());

        $this->dispatch(new CheckDirectoryPermissions());
        $this->dispatch(new InitializeApplication());
        $this->dispatch(new AutoloadEntryModels());
        $this->dispatch(new AddAssetNamespaces());
        $this->dispatch(new AddImageNamespaces());
        $this->dispatch(new AddTwigExtensions());
        $this->dispatch(new RegisterAddons());
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
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Collective\Html\HtmlServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');

        /**
         * Register the application instance. This is
         * used to determine the application state / reference.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Application\Application',
            'Anomaly\Streams\Platform\Application\Application'
        );

        /**
         * Register our own exception handler. This will let
         * us intercept exceptions and make them pretty if
         * not in debug mode.
         */
        $this->app->bind(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            'Anomaly\Streams\Platform\Exception\ExceptionHandler'
        );

        /**
         * Register our messages service. This is used for
         * error reporting and other messages.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Message\MessageBag',
            'Anomaly\Streams\Platform\Message\MessageBag'
        );

        /**
         * Register these common support instances
         * as singletons. They're used a lot.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Configurator',
            'Anomaly\Streams\Platform\Support\Configurator'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Evaluator',
            'Anomaly\Streams\Platform\Support\Evaluator'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Parser',
            'Anomaly\Streams\Platform\Support\Parser'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Support\Resolver',
            'Anomaly\Streams\Platform\Support\Resolver'
        );

        /**
         * Register the assets utility.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Asset\Asset',
            'Anomaly\Streams\Platform\Asset\Asset'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Asset\AssetPaths',
            'Anomaly\Streams\Platform\Asset\AssetPaths'
        );

        /**
         * Register the image utility.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Image\Image',
            'Anomaly\Streams\Platform\Image\Image'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Image\ImagePaths',
            'Anomaly\Streams\Platform\Image\ImagePaths'
        );

        /**
         * Register the view template DTO.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\View\ViewTemplate ',
            'Anomaly\Streams\Platform\View\ViewTemplate'
        );

        /**
         * Register table UI services and components.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry',
            'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewRegistry'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry',
            'Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterRegistry'
        );

        /**
         * Register button UI services.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry',
            'Anomaly\Streams\Platform\Ui\Button\ButtonRegistry'
        );

        /**
         * Register the entry model and repository.
         * This will help others swap it out as needed.
         */
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            'Anomaly\Streams\Platform\Entry\EntryModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            'Anomaly\Streams\Platform\Entry\EntryRepository'
        );

        /**
         * Register the field model and repository.
         * This will help others swap it out as needed.
         */
        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            'Anomaly\Streams\Platform\Field\FieldModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            'Anomaly\Streams\Platform\Field\FieldRepository'
        );

        /**
         * Register the streams model and repository.
         * This will help others swap it out as needed.
         */
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            'Anomaly\Streams\Platform\Stream\StreamModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            'Anomaly\Streams\Platform\Stream\StreamRepository'
        );

        /**
         * Register the assignments model and repository.
         * This will help others swap it out as needed.
         */
        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            'Anomaly\Streams\Platform\Assignment\AssignmentModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            'Anomaly\Streams\Platform\Assignment\AssignmentRepository'
        );

        /**
         * Register the addon collections and models as
         * needed. This lets us access loaded addons and
         * any state they're in at any time without reloading.
         */
        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\ModuleModel',
            'Anomaly\Streams\Platform\Addon\Module\ModuleModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Module\Contract\ModuleRepositoryInterface',
            'Anomaly\Streams\Platform\Addon\Module\ModuleRepository'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection',
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'
        );

        $this->app->bind(
            'module.collection',
            'Anomaly\Streams\Platform\Addon\Module\ModuleCollection'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionModel'
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Addon\Extension\Contract\ExtensionRepositoryInterface',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionRepository'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection'
        );

        $this->app->bind(
            'extension.collection',
            'Anomaly\Streams\Platform\Addon\Extension\ExtensionCollection'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection',
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection'
        );

        $this->app->bind(
            'field_type.collection',
            'Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection',
            'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection'
        );

        $this->app->bind(
            'plugin.collection',
            'Anomaly\Streams\Platform\Addon\Plugin\PluginCollection'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Block\BlockCollection',
            'Anomaly\Streams\Platform\Addon\Block\BlockCollection'
        );

        $this->app->bind(
            'block.collection',
            'Anomaly\Streams\Platform\Addon\Block\BlockCollection'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection',
            'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'
        );

        $this->app->bind(
            'theme.collection',
            'Anomaly\Streams\Platform\Addon\Theme\ThemeCollection'
        );

        /**
         * These view namespace classes are used
         * pretty often. Let's make them singletons.
         */
        $this->app->singleton(
            'Anomaly\Streams\Platform\View\ViewComposer',
            'Anomaly\Streams\Platform\View\ViewComposer'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\View\ViewOverrides',
            'Anomaly\Streams\Platform\View\ViewOverrides'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\View\ViewMobileOverrides',
            'Anomaly\Streams\Platform\View\ViewMobileOverrides'
        );

        /**
         * Change the default language path to our own.
         * This will make it easier to manage translations.
         */
        $this->app->bind(
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
        if (env('INSTALLED', null) === null && $this->app->make('request')->path() !== 'installer') {

            $this->app->make('router')->any(
                '{url?}',
                function (Redirector $redirector) {
                    return $redirector->to('installer');
                }
            )->where(['url' => '[-a-z0-9/]+']);
        }

        // Views
        $this->app->make('view')->addNamespace('streams', __DIR__ . '/../resources/views');
        $this->app->make('view')->composer('*', 'Anomaly\Streams\Platform\View\ViewComposer');

        // Register streams console provider.
        $this->app->register('Anomaly\Streams\Platform\StreamsConsoleProvider');

        // Register streams event provider.
        $this->app->register('Anomaly\Streams\Platform\StreamsEventProvider');
    }
}
