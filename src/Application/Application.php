<?php

namespace Anomaly\Streams\Platform\Application;

/**
 * Class Application
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Application
{

    /**
     * The application locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * The enabled state of the application.
     *
     * @var bool
     */
    protected $enabled;

    /**
     * Keep installed status around.
     *
     * @var bool
     */
    protected $installed;

    /**
     * The application table prefix.
     *
     * @var string
     */
    protected $tablePrefix;

    /**
     * The application reference.
     *
     * @var string
     */
    protected $reference = 'default';

    /**
     * Get the reference.
     *
     * @return null
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set the reference.
     *
     * @param $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get the storage path for the application.
     *
     * @param  string $path
     * @return string
     */
    public function getStoragePath($path = '')
    {
        return storage_path(
            'streams' . DIRECTORY_SEPARATOR . $this->getReference()
        ) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the public assets path for the application.
     *
     * @param  string $path
     * @return string
     */
    public function getAssetsPath($path = '')
    {
        return public_path(
            'app' . DIRECTORY_SEPARATOR . $this->getReference()
        ) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the resources path for the application.
     *
     * @param  string $path
     * @return string
     */
    public function getResourcesPath($path = '')
    {
        return base_path(
            'resources' . DIRECTORY_SEPARATOR . $this->getReference()
        ) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Return the app reference.
     *
     * @return string
     */
    public function tablePrefix()
    {
        return $this->tablePrefix;
    }

    /**
     * Get the resolved locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Return if the application is enabled.
     *
     * @return bool
     */
    public function isEnabled()
    {
        if (is_null($this->enabled)) {
            return true;
        }

        return (bool) $this->enabled;
    }

    /**
     * Is the application installed?
     *
     * @return bool
     */
    public function isInstalled()
    {
        if (is_null($this->installed)) {
            $this->installed = file_exists(base_path('.env'));
        }

        return $this->installed;
    }

    /**
     * Return if admin request or not.
     *
     * @return bool
     */
    public static function isAdmin()
    {
        // @todo push this segment into configuration.
        return request()->segment(1) == 'admin';
    }
}
