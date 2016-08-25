<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LocateApplication
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class LocateApplication implements SelfHandling
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
