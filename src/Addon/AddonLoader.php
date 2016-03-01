<?php namespace Anomaly\Streams\Platform\Addon;

use Composer\Autoload\ClassLoader;

/**
 * Class AddonLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonLoader
{

    /**
     * The class loader instance.
     *
     * @var ClassLoader
     */
    protected $loader;

    /**
     * Create a new AddonLoader instance.
     */
    public function __construct()
    {
        foreach (spl_autoload_functions() as $loader) {
            if ($loader[0] instanceof ClassLoader) {
                $this->loader = $loader[0];
            }
        }

        if (!$this->loader) {
            throw new \Exception("The ClassLoader could not be found.");
        }
    }

    /**
     * Load the addon.
     *
     * @param $path
     */
    public function load($path)
    {
        if (!file_exists($autoload = $path . '/vendor/autoload.php')) {
            return;
        }

        include $autoload;
    }

    /**
     * Register the loader.
     */
    public function register()
    {
        $this->loader->register();
    }
}
