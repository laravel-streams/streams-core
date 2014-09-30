<?php namespace Streams\Platform\Http\Filter;

class ThemeFilter
{
    /**
     * Setup the active theme.
     *
     * @return mixed
     */
    public function filter()
    {
        $view       = app()->make('view');
        $request    = app()->make('request');
        $translator = app()->make('translator');

        $asset  = app()->make('streams.asset');
        $image  = app()->make('streams.image');
        $themes = app()->make('streams.themes');


        // @todo - get this from the database.
        if ($request->segment(1) == 'admin') {
            $themes->setActive('streams');
        } else {
            $themes->setActive('aiws');
        }

        $theme = $themes->active();

        // @todo - replace this with distribution logic
        if (!$theme) {
            $theme = $themes->find('streams');
        }


        // Setup namespace for the active theme.
        $asset->addNamespace('theme', $theme->getPath('resources'));
        $image->addNamespace('theme', $theme->getPath('resources'));
        $view->addNamespace('theme', $theme->getPath('resources/views'));
        $translator->addNamespace('theme', $theme->getPath('resources/lang'));
    }
}
