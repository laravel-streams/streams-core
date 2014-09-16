<?php namespace Streams\Core\Http\Filter;

use Streams\Core\Assignment\Model\AssignmentModel;
use Streams\Core\Assignment\Observer\AssignmentObserver;
use Streams\Core\Entry\Model\EntryModel;
use Streams\Core\Entry\Observer\EntryObserver;
use Streams\Core\Field\Model\FieldModel;
use Streams\Core\Field\Observer\FieldObserver;
use Streams\Core\Model\EloquentModel;
use Streams\Core\Model\Observer\EloquentObserver;
use Streams\Core\Stream\Model\StreamModel;
use Streams\Core\Stream\Observer\StreamObserver;

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

            \Lang::addNamespace('theme', $theme->getPath('lang'));

            // Set the active module
            if (\Request::segment(1) == 'admin') {
                \Module::setActive(\Request::segment(2));
            } else {
                \Module::setActive(\Request::segment(1));
            }

            // Add the module namespace.
            if ($module = \Module::active()) {
                \View::addNamespace('module', $module->getPath('views'));
                \Lang::addNamespace('module', $module->getPath('lang'));
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

            // Set observer on core models.
            EntryModel::observe(new EntryObserver());
            FieldModel::observe(new FieldObserver());
            StreamModel::observe(new StreamObserver());
            EloquentModel::observe(new EloquentObserver());
            AssignmentModel::observe(new AssignmentObserver());
        }
    }

}
