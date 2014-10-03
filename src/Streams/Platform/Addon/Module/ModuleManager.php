<?php namespace Streams\Platform\Addon\Module;

use Illuminate\Container\Container;
use Streams\Platform\Addon\AddonManager;

class ModuleManager extends AddonManager
{
    /**
     * The folder within addons locations to load modules from.
     *
     * @var string
     */
    protected $folder = 'modules';

    /**
     * The slug of the currently active module.
     *
     * @var null
     */
    protected $active = null;

    /**
     * Return the active module.
     *
     * @return null|\Streams\Platform\Addon\AddonAbstract
     */
    public function active()
    {
        if ($this->exists($this->active)) {
            return $this->make($this->active);
        }

        return null;
    }

    /**
     * Install the addon.
     *
     * @return mixed
     */
    public function install()
    {
        return $this->newInstaller()->install();
    }

    /**
     * Uninstall the addon.
     *
     * @return mixed
     */
    public function uninstall()
    {
        return $this->newInstaller()->uninstall();
    }

    /**
     * Set the installed property.
     *
     * @return bool
     */
    public function setInstalled($installed)
    {
        $this->installed = $installed;

        return $this;
    }

    /**
     * Set the enabled property.
     *
     * @return bool
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get the active module slug.
     *
     * @return null
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the active module slug.
     *
     * @param $slug
     * @return $this
     */
    public function setActive($slug)
    {
        $this->active = $slug;

        return $this;
    }

    /**
     * Return if an addon is installed or not.
     *
     * @param $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        return $this->make($slug)->isInstalled();
    }

    /**
     * Return if an addon is enabled or not.
     *
     * @param $slug
     * @return bool
     */
    public function isEnabled($slug)
    {
        return $this->make($slug)->isEnabled();
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return new ModuleModel();
    }

    /**
     * Return a new module collection.
     *
     * @param array $addons
     * @return ModuleCollection
     */
    protected function newCollection(array $addons)
    {
        return new ModuleCollection($addons);
    }
}
