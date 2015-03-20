<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;

/**
 * Class CheckDirectoryPermissions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class CheckDirectoryPermissions implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Filesystem  $files
     * @param Application $application
     */
    public function handle(Filesystem $files, Application $application)
    {
        if (env('INSTALLED') && !env('APP_DEBUG')) {
            return;
        }

        $paths = [
            'public/assets',
            'public/assets/' . $application->getReference()
        ];

        foreach ($paths as $path) {
            if ($files->exists(base_path($path)) && !$files->isWritable(base_path($path))) {
                die("chmod -R 777 " . base_path($path));
            }
        }
    }
}
