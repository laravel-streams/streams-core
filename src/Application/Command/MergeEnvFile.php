<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class MergeEnvFile
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class MergeEnvFile implements SelfHandling
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param Application $application
     * @param Filesystem  $files
     */
    public function handle(Application $application, Filesystem $files)
    {
        if ($files->exists($env = $application->getResourcesPath('.env'))) {

            dd(env('TEST'));
        }
    }
}
