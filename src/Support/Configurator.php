<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use SplFileInfo;

/**
 * Class Configurator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        if (!$this->files->isDirectory($directory)) {
            return;
        }

        /* @var SplFileInfo $file */
        foreach ($this->files->allFiles($directory) as $file) {

            $key = $this->getKeyFromFile($directory, $file);

            $this->config->set("{$namespace}::{$key}", $this->files->getRequire($file->getPathname()));
        }
    }

    /**
     * Add namespace overrides to configuration.
     *
     * @param $namespace
     * @param $directory
     */
    public function addNamespaceOverrides($namespace, $directory)
    {
        if (!$this->files->isDirectory($directory)) {
            return;
        }

        /* @var SplFileInfo $file */
        foreach ($this->files->allFiles($directory) as $file) {

            $key = $this->getKeyFromFile($directory, $file);

            $this->config->set(
                "{$namespace}::{$key}",
                array_replace(
                    $this->config->get("{$namespace}::{$key}", []),
                    $this->files->getRequire($file->getPathname())
                )
            );
        }
    }

    /**
     * Parse a key from the file
     *
     * @param             $directory
     * @param SplFileInfo $file
     * @return string
     */
    private function getKeyFromFile($directory, SplFileInfo $file)
    {
        $key = trim(
            str_replace(
                str_replace('\\', DIRECTORY_SEPARATOR, $directory),
                '',
                $file->getPath()
            ) . DIRECTORY_SEPARATOR . $file->getBaseName('.php'),
            DIRECTORY_SEPARATOR
        );

        /**
         * Normalize slashes so that the key
         * reader knows how to work with them.
         */
        return str_replace(DIRECTORY_SEPARATOR, '/', $key);
    }
}
