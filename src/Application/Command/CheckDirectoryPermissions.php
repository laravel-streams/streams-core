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
        // Skip it if we're not in debug mode or not installed.
        if (!$application->isInstalled() || !env('APP_DEBUG')) {
            return;
        }

        $paths = [
            'public/assets',
            'public/assets/' . $application->getReference()
        ];

        foreach ($paths as $path) {
            if ($files->exists(base_path($path)) && !$files->isWritable(base_path($path))) {
                abort(500, "[{$path}] must be writable: \n\nchmod -R 775 " . base_path($path));
            }
        }
    }
}
