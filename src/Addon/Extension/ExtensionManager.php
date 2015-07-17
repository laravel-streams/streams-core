<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ExtensionManager
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionManager
{

    use DispatchesJobs;

    /**
     * Install a module.
     *
     * @param Extension $module
     * @param bool      $seed
     */
    public function install(Extension $module, $seed = false)
    {
        $this->dispatch(new InstallExtension($module, $seed));
    }

    /**
     * Uninstall a module.
     *
     * @param Extension $module
     */
    public function uninstall(Extension $module)
    {
        $this->dispatch(new UninstallExtension($module));
    }
}
