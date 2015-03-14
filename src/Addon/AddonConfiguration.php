<?php namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

/**
 * Class AddonConfiguration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonConfiguration
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new AddonConfiguration instance.
     *
     * @param Repository $config
     * @param Filesystem $filesystem
     */
    public function __construct(Repository $config, Filesystem $filesystem)
    {
        $this->config     = $config;
        $this->filesystem = $filesystem;
    }

    /**
     * Load an addon's config.
     *
     * @param Addon $addon
     */
    public function load(Addon $addon)
    {
        if (is_dir($addon->getPath('resources/config'))) {
            $this->loadConfig($addon);
        }
    }

    /**
     * Load the addon configuration files.
     *
     * @param Addon $addon
     */
    protected function loadConfig(Addon $addon)
    {
        foreach ($this->filesystem->files($addon->getPath('resources/config')) as $file) {

            $key = trim(basename($file), '.php');

            $this->config->set($addon->getNamespace($key), $this->filesystem->getRequire($file));
        }
    }
}
