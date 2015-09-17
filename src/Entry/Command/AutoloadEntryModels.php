<?php

namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Application\Application;
use Composer\Autoload\ClassLoader;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class AutoloadEntryModels.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class AutoloadEntryModels implements SelfHandling
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
