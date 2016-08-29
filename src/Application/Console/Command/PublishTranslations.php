<?php namespace Anomaly\Streams\Platform\Application\Console\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PublishTranslations
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
        $destination = storage_path('streams/lang');

        $filesystem->copyDirectory(
            __DIR__ . '/../../../../resources/lang',
            $application->getResourcesPath('streams/lang')
        );
    }
}
