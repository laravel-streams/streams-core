<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Configuration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Configuration
{

    /**
     * The configuration repository.
     *
     * @var Repository
     */
    protected $repository;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new Configuration instance.
     *
     * @param Filesystem $filesystem
     * @param Repository $repository
     */
    public function __construct(Filesystem $filesystem, Repository $repository)
    {
        $this->filesystem = $filesystem;
        $this->repository = $repository;
    }

    /**
     * Load configuration from a directory to a namespace.
     *
     * @param $namespace
     * @param $directory
     */
    public function load($namespace, $directory)
    {
        if ($this->filesystem->exists($directory)) {
            $this->loadConfiguration($namespace, $directory);
        }
    }

    /**
     * Load a configuration file.
     *
     * @param $namespace
     * @param $directory
     */
    protected function loadConfiguration($namespace, $directory)
    {
        foreach ($this->filesystem->files($directory) as $file) {

            dd($file);

            $this->repository->set("{$namespace}::{$key}");
        }
    }
}
