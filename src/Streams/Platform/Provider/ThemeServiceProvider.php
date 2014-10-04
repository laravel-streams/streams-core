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
     * Register the service provider.
     */
    public function register()
    {
        $view       = app('view');
        $request    = app('request');
        $translator = app('translator');

        $asset  = app('streams.asset');
        $image  = app('streams.image');
        $themes = app('streams.themes');


        // @todo - get this from the database.
        if ($request->segment(1) == 'admin') {
            $theme = $themes->get('streams');
        } else {
            $theme = $themes->get('aiws');
        }

        // @todo - replace this with distribution logic
        if (!$theme) {
            $theme = $themes->make('streams');
        }


        // Setup namespace for the active theme.
        $asset->addNamespace('theme', $theme->getPath('resources'));
        $image->addNamespace('theme', $theme->getPath('resources'));
        $view->addNamespace('theme', $theme->getPath('resources/views'));
        $translator->addNamespace('theme', $theme->getPath('resources/lang'));
    }
}
