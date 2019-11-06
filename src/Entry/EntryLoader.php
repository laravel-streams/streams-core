<?php

namespace Anomaly\Streams\Platform\Entry;

use Composer\Autoload\ClassLoader;

/**
 * Class EntryLoader
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EntryLoader
{

    /**
     * Autoload entry models.
     */
    static public function load()
    {
        $loader = null;

        foreach (spl_autoload_functions() as $autoloader) {
            if (is_array($autoloader) && $autoloader[0] instanceof ClassLoader) {
                $loader = $autoloader[0];
            }
        }

        if (!$loader) {
            throw new \Exception("The ClassLoader could not be found.");
        }

        /**
         * If a classmap is available then that's
         * much more preferred than registering.
         */
        if (file_exists($classmap = application()->getStoragePath('models/classmap.php'))) {

            $loader->addClassMap(include $classmap);

            return;
        }

        /* @var ClassLoader $loader */
        $loader->addPsr4('Anomaly\Streams\Platform\Model\\', application()->getStoragePath('models'));

        $loader->register();
    }
}
