<?php namespace Streams\Platform\Addon;

use Streams\Platform\Support\Installer;

class AddonInstaller extends Installer
{
    /**
     * The installers to run.
     *
     * @var array
     */
    protected $installers = [];

    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonInterface
     */
    protected $addon;

    /**
     * Create a new AddonInstallerAbstract instance.
     *
     * @param AddonInterface $addon
     */
    public function __construct(AddonInterface $addon)
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
        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->install();
        }

        die('INSTALLED');

        return true;
    }

    /**
     * Uninstall an addon.
     *
     * @return bool
     */
    public function uninstall()
    {
        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->uninstall();
        }

        die('UNINSTALLED');

        return true;
    }
}
