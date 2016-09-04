<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Application\Application;
use Composer\Autoload\ClassLoader;

/**
 * Class AutoloadEntryModels
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AutoloadEntryModels
{

    /**
     * Handle the command.
     *
     * @param ClassLoader $loader
     * @param Application $application
     */
    public function handle(ClassLoader $loader, Application $application)
    {
        $loader->addPsr4('Anomaly\Streams\Platform\Model\\', $application->getStoragePath('models'));

        $loader->register();
    }
}
