<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ActiveThemeServiceProvider extends ServiceProvider
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
        $request      = app('request');
        $distribution = app('streams.distribution');

        if ($request->segment(1) == 'admin') {

            $theme = $distribution->getAdminTheme();

        } else {

            $theme = $distribution->getPublicTheme();
            
        }

        $theme->setActive(true);

        // Setup namespace hints for a short namespace.
        app('view')->addNamespace('theme', $theme->getPath('resources/views'));
        app('streams.asset')->addNamespace('theme', $theme->getPath('resources'));
        app('streams.image')->addNamespace('theme', $theme->getPath('resources'));
        app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));
    }
}
