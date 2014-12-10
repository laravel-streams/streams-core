<?php namespace Anomaly\Streams\Platform\Provider;

class ActiveThemeServiceProvider extends \Illuminate\Support\ServiceProvider
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
        $request = app('request');
        $theme   = null;

        if ($distribution = app('streams.distributions')->active()) {

            if ($request->segment(1) == 'admin' or $request->segment(1) == 'installer') {

                $theme = $distribution->getDefaultAdminTheme();
            } else {

                $theme = $distribution->getDefaultPublicTheme();
            }

            $theme = app('streams.theme.' . $theme);

            if ($theme) {
                $theme->setActive(true);

                // Setup namespace hints for a short namespace.
                app('view')->addNamespace('theme', $theme->getPath('resources/views'));
                app('config')->addNamespace('theme', $theme->getPath('resources/config'));
                app('streams.asset')->addNamespace('theme', $theme->getPath('resources'));
                app('streams.image')->addNamespace('theme', $theme->getPath('resources'));
                //app('translator')->addNamespace('theme', $theme->getPath('resources/lang'));
            }
        }
    }
}
