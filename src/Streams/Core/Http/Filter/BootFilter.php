<?php namespace Streams\Core\Http\Filter;

class BootFilter
{

    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter()
    {
        if (\Application::isInstalled()) {

            \Application::boot();

            if (\Request::segment(1) === 'admin') {
                $theme = \Theme::getAdminTheme();
            } else {
                $theme = \Theme::getPublicTheme();
            }

            // Add the module namespace.
            if ($module = \Module::getActive()) {
                \View::addNamespace('module', $module->getPath('views'));
            }

            // Add the theme namespace.
            \View::addNamespace('theme', $theme->getPath('views'));
            \Asset::addNamespace('theme', $theme->getPath());
            \Image::addNamespace('theme', $theme->getPath());

            // Overload views with the composer.
            \View::composer('*', 'Streams\Core\Support\Composer');

            // Set some placeholders.
            \View::share('title', null);
            \View::share('description', null);
        }
    }

}
