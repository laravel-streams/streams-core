<?php

namespace Anomaly\Streams\Platform\Support;

use FilesystemIterator;
use RecursiveDirectoryIterator;
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
     * Load configuration from a directory.
     *
     * @param $directory
     * @param $hint
     */
    static public function load($directory, $hint)
    {

        /* @var SplFileInfo $file */
        foreach ((new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {

            if (!$file->isFile()) {
                continue;
            }

            $key = self::getKeyFromFile($directory, $file);

            config()->set("{$hint}::{$key}", include_once $file->getPathname());
        }
    }

    /**
     * Add namespace overrides to configuration.
     *
     * @param $directory
     * @param $hint
     */
    static public function merge($directory, $hint)
    {

        /* @var SplFileInfo $file */
        foreach ((new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)) as $file) {

            if (!$file->isFile()) {
                continue;
            }

            $key = self::getKeyFromFile($directory, $file);

            config()->set(
                "{$hint}::{$key}",
                array_replace(
                    config("{$hint}::{$key}", []),
                    include_once $file->getPathname()
                )
            );
        }
    }

    /**
     * Parse a key from the file
     *
     * @param $directory
     * @param SplFileInfo $file
     * @return string
     */
    static protected function getKeyFromFile($directory, SplFileInfo $file)
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
