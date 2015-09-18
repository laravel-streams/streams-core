<?php

namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ExtensionManager.
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
     * @return bool
     */
    public function install(Extension $module, $seed = false)
    {
        return $this->dispatch(new InstallExtension($module, $seed));
    }

    /**
     * Uninstall a module.
     *
     * @param Extension $module
     * @return bool
     */
    public function uninstall(Extension $module)
    {
        return $this->dispatch(new UninstallExtension($module));
    }
}
