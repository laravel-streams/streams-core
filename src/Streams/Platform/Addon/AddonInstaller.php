<?php namespace Streams\Platform\Addon;

use Streams\Platform\Support\Installer;
use Streams\Platform\Traits\EventableTrait;
use Streams\Platform\Traits\DispatchableTrait;

class AddonInstaller extends Installer
{
    use EventableTrait;
    use DispatchableTrait;

    /**
     * The installers to run.
     *
     * @var array
     */
    protected $installers = [];

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

        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->install();
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

        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->uninstall();
        }

        $this->fire('after_uninstall');

        return true;
    }
}
