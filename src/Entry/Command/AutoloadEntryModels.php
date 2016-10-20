<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Application\Application;
use Composer\Autoload\ClassLoader;

/**
 * Class AutoloadEntryModels
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
