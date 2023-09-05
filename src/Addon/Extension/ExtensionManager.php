<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Command\DisableExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\EnableExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\MigrateExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class ExtensionManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ExtensionManager
{
    use DispatchesJobs;

    /**
     * Install a module.
     *
     * @param  Extension $module
     * @param  bool      $seed
     * @return bool
     */
    public function install(Extension $module, $seed = false)
    {
        return dispatch_sync(new InstallExtension($module, $seed));
    }

    /**
     * Migrate a module.
     *
     * @param  Extension $module
     * @param  bool      $seed
     * @return bool
     */
    public function migrate(Extension $module, $seed = false)
    {
        return dispatch_sync(new MigrateExtension($module, $seed));
    }

    /**
     * Uninstall a module.
     *
     * @param  Extension $module
     * @return bool
     */
    public function uninstall(Extension $module)
    {
        return dispatch_sync(new UninstallExtension($module));
    }

    /**
     * Enable a extension.
     *
     * @param Extension $extension
     * @param bool   $seed
     */
    public function enable(Extension $extension)
    {
        dispatch_sync(new EnableExtension($extension));
    }

    /**
     * Disable a extension.
     *
     * @param Extension $extension
     */
    public function disable(Extension $extension)
    {
        dispatch_sync(new DisableExtension($extension));
    }

}
