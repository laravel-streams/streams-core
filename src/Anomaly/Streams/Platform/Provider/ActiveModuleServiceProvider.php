<?php namespace Anomaly\Streams\Platform\Provider;

class ActiveModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Setup the environment with the active module.
     */
    public function register()
    {
        $request = app('request');

        // Determine the active module.
        if ($request->segment(1) == 'admin') {

            $module = app('streams.modules')->findBySlug($request->segment(2));
        } else {

            $module = app('streams.modules')->findBySlug($request->segment(1));
        }

        if ($module) {

            $module->setActive(true);

            // Setup namespace hints for a short namespace.
            app('view')->addNamespace('module', $module->getPath('resources/views'));
            app('streams.asset')->addNamespace('module', $module->getPath('resources'));
            app('streams.image')->addNamespace('module', $module->getPath('resources'));
            //app('translator')->addNamespace('module', $module->getPath('resources/lang'));
        }
    }
}
