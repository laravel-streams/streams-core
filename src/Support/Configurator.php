<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use SplFileInfo;

/**
 * Class Configurator.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Configurator
{
    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new Configurator instance.
     *
     * @param Filesystem $files
     * @param Repository $config
     */
    public function __construct(Filesystem $files, Repository $config)
    {
        $this->files  = $files;
        $this->config = $config;
    }

    /**
     * Add a namespace to configuration.
     *
     * @param $namespace
     * @param $directory
     */
    public function addNamespace($namespace, $directory)
    {
        if (! $this->files->isDirectory($directory)) {
            return;
        }

        /* @var SplFileInfo $file */
        foreach ($this->files->allFiles($directory) as $file) {
            $key = ltrim(
                str_replace(
                    $directory,
                    '',
                    $file->getPath()
                ).'/'.$file->getBaseName('.php'),
                '/'
            );

            $this->config->set($namespace.'::'.$key, $this->files->getRequire($file->getPathname()));
        }
    }

    /**
     * Merge a namespace to configuration.
     *
     * @param $namespace
     * @param $directory
     */
    public function mergeNamespace($namespace, $directory)
    {
        if (! $this->files->isDirectory($directory)) {
            return;
        }

        /* @var SplFileInfo $file */
        foreach ($this->files->allFiles($directory) as $file) {
            $key = ltrim(
                str_replace(
                    $directory,
                    '',
                    $file->getPath()
                ).'/'.$file->getBaseName('.php'),
                '/'
            );

            $this->config->set(
                $namespace.'::'.$key,
                array_replace(
                    $this->config->get($namespace.'::'.$key, []),
                    $this->files->getRequire($file->getPathname())
                )
            );
        }
    }
}
