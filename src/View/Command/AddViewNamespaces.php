<?php namespace Anomaly\Streams\Platform\View\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\View\Factory;

/**
 * Class AddViewNamespaces
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Command
 */
class AddViewNamespaces implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Application $application
     * @param Factory     $views
     */
    public function handle(Application $application, Factory $views)
    {
        $views->composer('*', 'Anomaly\Streams\Platform\View\ViewComposer');
        $views->addNamespace('streams', __DIR__ . '/../../../resources/views');
        $views->addNamespace('storage', $application->getStoragePath());
        $views->addNamespace('base_path', base_path());
    }
}
