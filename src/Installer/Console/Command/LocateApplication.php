<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Application\Application;

/**
 * Class LocateApplication
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LocateApplication
{

    /**
     * Handle the application.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {
        $application
            ->setReference(env('APPLICATION_REFERENCE'))
            ->locate();
    }
}
