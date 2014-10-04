<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Setup the environment with the active theme.
     */
    public function register()
    {
        $request    = app('request');

        // @todo - get this from settings.
        if ($request->segment(1) == 'admin') {
            $theme = app('streams.themes')->get('streams');
        } else {
            $theme = app('streams.themes')->get('streams');
        }

        // Register the active theme.
        $this->app['streams.theme.active'] = $theme;

        // Setup namespace hints for a short namespace.
        app('view')->addNamespace('theme', $theme->getPath('resources/views'));
        app('streams.asset')->addNamespace('theme', $theme->getPath('resources'));
        app('streams.image')->addNamespace('theme', $theme->getPath('resources'));
        app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));
    }
}
