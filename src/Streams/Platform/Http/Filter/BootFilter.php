<?php namespace Streams\Platform\Http\Filter;

use Streams\Platform\Model\EloquentModel;
use Streams\Platform\Entry\Model\EntryModel;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Foundation\Application;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Entry\Observer\EntryObserver;
use Streams\Platform\Field\Observer\FieldObserver;
use Streams\Platform\Model\Observer\EloquentObserver;
use Streams\Platform\Stream\Observer\StreamObserver;
use Streams\Platform\Assignment\Model\AssignmentModel;
use Streams\Platform\Assignment\Observer\AssignmentObserver;

class BootFilter
{
    /**
     * Run the request filter.
     *
     * @return mixed
     */
    public function filter()
    {
        $application = app()->make('streams.application');
        $asset       = app()->make('streams.asset');
        $image       = app()->make('streams.image');
        $view        = app()->make('view');
        $translator  = app()->make('translator');

        if (!$application->isInstalled()) {
            return;
        }

        $application->setup();

        if (\Request::segment(1) === 'admin') {
            \Theme::setActive('streams');
        } else {
            \Theme::setActive('aiws');
        }

        $theme = \Theme::active();

        // @todo - replace this with distribution logic
        if (!$theme) {
            $theme = \Theme::find('streams');
        }

        $translator->addNamespace('theme', $theme->getPath('resources/lang'));

        // Set the active module
        if (\Request::segment(1) == 'admin') {
            \Module::setActive(\Request::segment(2));
        } else {
            \Module::setActive(\Request::segment(1));
        }

        // Add the module namespace.
        if ($module = \Module::active()) {
            $view->addNamespace('module', $module->getPath('resources/views'));
            $translator->addNamespace('module', $module->getPath('resources/lang'));
        }

        // Add the theme namespace.
        $view->addNamespace('theme', $theme->getPath('resources/views'));
        $asset->addNamespace('theme', $theme->getPath('resources'));
        $image->addNamespace('theme', $theme->getPath('resources'));

        // Overload views with the composer.
        $view->composer('*', 'Streams\Platform\Support\Composer');

        // Set some placeholders.
        $view->share('title', null);
        $view->share('description', null);

        if ($application->isInstalled()) {
            if ($locale = \Input::get('locale')) {
                \Sentry::getUser()->changeLocale($locale);
            }

            // Set Locale
            if (\Sentry::check()) {
                \App::setLocale(\Sentry::getUser()->getLocale(\Config::get('locale')));
            }
        }

        // Set observer on core models.
        EntryModel::observe(new EntryObserver());
        FieldModel::observe(new FieldObserver());
        StreamModel::observe(new StreamObserver());
        EloquentModel::observe(new EloquentObserver());
        AssignmentModel::observe(new AssignmentObserver());
    }

}
