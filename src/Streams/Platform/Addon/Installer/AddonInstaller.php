<?php namespace Streams\Platform\Addon\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Installer\FieldInstaller;
use Streams\Platform\Stream\Installer\StreamInstaller;

class AddonInstaller extends Installer
{
    /**
     * The installers to install.
     *
     * @var array
     */
    protected $install = [];

    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonAbstract
     */
    protected $addon;

    /**
     * Create a new AddonInstallerAbstract instance.
     *
     * @param AddonAbstract $addon
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;
    }

    /**
     * Install the addon.
     *
     * @return bool
     */
    public function install()
    {
        $this->fire('before_install');

        foreach ($this->install as $installer) {
            (new $installer($this->addon))->install();
        }

        $this->fire('after_install');

        return true;
    }

    /**
     * Uninstall an addon.
     *
     * @return bool
     */
    public function uninstall()
    {
        $this->fire('before_uninstall');

        foreach ($this->install as $installer) {
            (new $installer($this->addon))->uninstall();
        }

        $this->fire('after_uninstall');

        return true;
    }

    /**
     * Save the state of the install.
     */
    protected function onAfterInstall()
    {
        $this->addon->model()->installed();
    }

    /**
     * Save the state of the uninstall.
     */
    protected function onAfterUninstall()
    {
        $this->addon->model()->uninstalled();
    }

    /**
     * Get the addon.
     *
     * @return AddonAbstract
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * Return a new FieldInstallerInstance.
     *
     * @return FieldInstaller
     */
    protected function newFieldInstaller()
    {
        return new FieldInstaller($this->addon);
    }
}
