<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Traits\EventableTrait;
use Laracasts\Commander\Events\DispatchableTrait;
use Streams\Platform\Addon\Module\Event\ModuleInstalledEvent;
use Streams\Platform\Addon\Module\Event\ModuleUninstalledEvent;

class ModuleInstaller extends Installer
{
    use EventableTrait;
    use DispatchableTrait;

    protected $installers = [];

    protected $addon;

    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;
    }

    public function install()
    {
        $this->fire('before_install');

        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->install();
        }

        $this->raise(new ModuleInstalledEvent($this->addon));

        $this->dispatchEventsFor($this);

        $this->fire('after_install');

        return true;
    }

    public function uninstall()
    {
        $this->fire('before_uninstall');

        foreach ($this->installers as $installer) {
            app()->make($installer, ['addon' => $this->addon])->uninstall();
        }

        $this->raise(new ModuleUninstalledEvent($this->addon));

        $this->dispatchEventsFor($this);

        $this->fire('after_uninstall');

        return true;
    }
}
