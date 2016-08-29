<?php namespace Anomaly\Streams\Platform\Search\Command;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Config\Repository;

class ConfigureScout
{
    /**
     * Handle the command.
     *
     * @param Application $application
     * @param Repository  $config
     */
    public function handle(Application $application, Repository $config, Filesystem $files)
    {
        $files->makeDirectory($application->getStoragePath('search'), 0777, true, true);

        $config->set('scout.tntsearch.storage', $application->getStoragePath('search'));
    }
}
