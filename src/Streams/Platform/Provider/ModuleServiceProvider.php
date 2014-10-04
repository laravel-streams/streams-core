<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
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

        $asset   = app('streams.asset');
        $image   = app('streams.image');
        $modules = app('streams.modules');


        // Set the active module
        if ($request->segment(1) == 'admin') {
            $module = $modules->get($request->segment(2));
        } else {
            $module = $modules->get($request->segment(1));
        }

        // Setup namespace for the active module.
        if ($module) {
            $asset->addNamespace('module', $module->getPath('resources'));
            $image->addNamespace('module', $module->getPath('resources'));
            $view->addNamespace('module', $module->getPath('resources/views'));
            $translator->addNamespace('module', $module->getPath('resources/lang'));
        }
    }
}
