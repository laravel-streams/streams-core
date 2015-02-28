<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;

/**
 * Class InitializeApplication
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class InitializeApplication implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {
        /**
         * If the application is installed
         * then locate the application and
         * initialize.
         */
        if ($application->isInstalled()) {

            if (env('DB_DRIVER')) {
                $application->locate();
                $application->setup();
            }

            return;
        }

        /**
         * If we're not installed just
         * assume default for now.
         */
        $application->setReference('default');
    }
}
