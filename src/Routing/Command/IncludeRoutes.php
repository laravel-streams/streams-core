<?php namespace Anomaly\Streams\Platform\Routing\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class IncludeRoutes
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Routing\Command
 */
class IncludeRoutes implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {
        if (file_exists($routes = base_path('resources/core/routes.php'))) {
            include $routes;
        }

        if (file_exists($routes = $application->getResourcesPath('routes.php'))) {
            include $routes;
        }
    }
}
