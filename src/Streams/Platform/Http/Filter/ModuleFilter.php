<?php namespace Streams\Platform\Http\Filter;

class ModuleFilter
{
    /**
     * Setup the active module.
     *
     * @return mixed
     */
    public function filter()
    {
        $view       = app()->make('view');
        $request    = app()->make('request');
        $translator = app()->make('translator');

        $asset   = app()->make('streams.asset');
        $image   = app()->make('streams.image');
        $modules = app()->make('streams.modules');


        // Set the active module
        if ($request->segment(1) == 'admin') {
            $modules->setActive($request->segment(2));
        } else {
            // @todo - unlike in the admin we can't assume frontend modules in use.
            $modules->setActive($request->segment(1));
        }

        $module = $modules->active();


        // Setup namespace for the active module.
        if ($module) {
            $asset->addNamespace('module', $module->getPath('resources'));
            $image->addNamespace('module', $module->getPath('resources'));
            $view->addNamespace('module', $module->getPath('resources/views'));
            $translator->addNamespace('module', $module->getPath('resources/lang'));
        }
    }
}
