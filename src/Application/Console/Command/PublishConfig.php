<?php namespace Anomaly\Streams\Platform\Application\Console\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishConfig
{
    /**
     * Handle the command.
     *
     * @param  Filesystem  $filesystem
     * @param  Application $application
     * @return string
     */
    public function handle(Filesystem $filesystem, Application $application)
    {
        $destination = storage_path('streams/config');
        
        $filesystem->copyDirectory(
            __DIR__ . '/../../../../resources/config',
            $application->getResourcesPath('streams/config')
        );
    }
}
