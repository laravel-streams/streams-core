<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * Class LoadEnvironmentOverrides
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class LoadEnvironmentOverrides implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Application $application
     */
    public function handle(Application $application)
    {
        if (!is_file($file = $application->getResourcesPath('.env'))) {
            return;
        }

        foreach (file($file, FILE_IGNORE_NEW_LINES) as $line) {

            // Check for # comments.
            if (!starts_with($line, '#')) {
                putenv($line);
            }
        }
    }
}
