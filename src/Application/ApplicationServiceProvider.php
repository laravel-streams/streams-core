<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Application\Command\CheckDirectoryPermissions;
use Anomaly\Streams\Platform\Application\Command\LocateApplication;
use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\ServiceProvider;

/**
 * Class ApplicationServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application
 */
class ApplicationServiceProvider extends ServiceProvider
{

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        // Set custom command mapper.
        $this->setCommandBusMapper();

        // Add HTML / form builder extensions to Twig.
        $this->app->make('twig')->addExtension(app('TwigBridge\Extension\Laravel\Form'));
        $this->app->make('twig')->addExtension(app('TwigBridge\Extension\Laravel\Html'));

        // Add streams translation path.
        $this->app->make('Illuminate\Translation\Translator')->addNamespace(
            'streams',
            $this->app['streams.path'] . '/resources/lang'
        );

        // Handle view  overloading for theme / mobile.
        $this->app->make('view')->composer('*', 'Anomaly\Streams\Platform\View\Composer');

        // Add markdown support to Twig
        $engine = new MichelfMarkdownEngine();

        $this->app->make('twig')->addExtension(new MarkdownExtension($engine));

        // Locate the application.
        $this->dispatch(new LocateApplication());

        // Check directory permissions.
        if (!app('Anomaly\Streams\Platform\Application\Application')->isInstalled()) {
            $this->dispatch(new CheckDirectoryPermissions());
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerApplication();
        $this->registerListeners();
        $this->configurePackages();
    }

    /**
     * Register the application.
     */
    protected function registerApplication()
    {
        $this->app->instance('streams.path', $this->app->make('path.base') . '/vendor/anomaly/streams-platform');

        $this->app->bind(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            'Anomaly\Streams\Platform\Exception\ExceptionHandler'
        );

        $this->app->bind(
            'path.lang',
            function () {
                return __DIR__ . '/../../resources/lang';
            }
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Application\Application',
            'Anomaly\Streams\Platform\Application\Application'
        );

        foreach ($this->app->make('files')->allFiles(__DIR__ . '/../../resources/config') as $file) {

            if (!$file instanceof \SplFileInfo) {
                continue;
            }

            $key = ltrim(
                str_replace(
                    __DIR__ . '/../../resources/config',
                    '',
                    $file->getPath()
                ) . '/' . $file->getBaseName('.php'),
                '/'
            );

            $this->app->make('config')->set(
                'streams::' . $key,
                $this->app->make('files')->getRequire($file->getPathname())
            );
        }

        $this->app->make('view')->addNamespace('streams', $this->app['streams.path'] . '/resources/views');
    }

    /**
     * Register the application listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Application\Listener\ApplicationBootingListener'
        );
    }

    /**
     * Manually configure 3rd party packages.
     */
    protected function configurePackages()
    {
        // Bind a string loader version of twig.
        $this->app->bind(
            'twig.string',
            function () {
                $twig = clone(app('twig'));

                $twig->setLoader(new \Twig_Loader_String());

                return $twig;
            }
        );
    }

    /**
     * Use a custom mapper for commands.
     */
    protected function setCommandBusMapper()
    {
        // Set the default command mapper.
        $this->app->make('Illuminate\Bus\Dispatcher')->mapUsing(
            function ($command) {

                $handler = explode('\\', get_class($command));

                array_splice($handler, count($handler) - 1, 0, 'Handler');

                return implode('\\', $handler) . 'Handler@handle';
            }
        );
    }
}
