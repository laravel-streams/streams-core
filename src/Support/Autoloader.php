<?php

namespace Anomaly\Streams\Platform\Support;

use Composer\Autoload\ClassLoader;

/**
 * Class Autoloader
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Autoloader
{

    /**
     * The class loader instance.
     *
     * @var ClassLoader
     */
    protected static $loader;

    /**
     * Load the addon.
     *
     * @param $path
     * @return $this
     */
    public static function load($path)
    {
        $loader = self::classLoader();

        if (is_array($path) && $paths = $path) {

            foreach ($paths as $path) {
                self::load($path);
            }
        }

        if (file_exists($autoload = $path . '/vendor/autoload.php')) {
            include $autoload;
        }

        if (!file_exists($path . '/composer.json')) {
            return;
        }

        if (!$composer = json_decode(file_get_contents($path . '/composer.json'), true)) {
            throw new \Exception("A JSON syntax error was encountered in {$path}/composer.json");
        }

        if (!array_key_exists('autoload', $composer)) {
            return;
        }

        foreach (array_get($composer['autoload'], 'psr-4', []) as $namespace => $autoload) {
            $loader->addPsr4($namespace, $path . '/' . $autoload, false);
        }

        foreach (array_get($composer['autoload'], 'psr-0', []) as $namespace => $autoload) {
            $loader->add($namespace, $path . '/' . $autoload, false);
        }

        foreach (array_get($composer['autoload'], 'files', []) as $file) {
            include($path . '/' . $file);
        }

        if ($classmap = array_get($composer['autoload'], 'classmap')) {
            $loader->addClassMap($classmap);
        }
    }

    /**
     * Register the loader.
     */
    public static function register()
    {
        self::classLoader()->register();
    }

    /**
     * Return the class loader.
     *
     * @return ClassLoader
     */
    public static function classLoader()
    {
        return spl_autoload_functions()[1][0];
    }
}
