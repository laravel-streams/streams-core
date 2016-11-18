<?php namespace Anomaly\Streams\Platform\View\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Application\Application;
use Illuminate\View\Factory;

/**
 * Class AddViewNamespaces
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddViewNamespaces
{

    /**
     * Handle the command.
     *
     * @param Application $application
     * @param Factory     $views
     */
    public function handle(Application $application, Factory $views, AddonCollection $addons)
    {
        /* @var Theme $theme */
        $theme = $addons->themes->current();

        $views->composer('*', 'Anomaly\Streams\Platform\View\ViewComposer');
        $views->addNamespace('streams', __DIR__ . '/../../../resources/views');
        $views->addNamespace('published', $application->getResourcesPath('addons'));
        $views->addNamespace('app', $application->getResourcesPath('views'));
        $views->addNamespace('storage', $application->getStoragePath());
        $views->addNamespace('shared', base_path('resources/views'));
        $views->addNamespace('root', base_path());
        $views->addExtension('html', 'php');
    }
}
