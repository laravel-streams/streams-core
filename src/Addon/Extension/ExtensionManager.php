<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\Extension\Command\InstallExtension;
use Anomaly\Streams\Platform\Addon\Extension\Command\SyncExtensions;
use Anomaly\Streams\Platform\Addon\Extension\Command\UninstallExtension;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Install a extension.
     *
     * @param  $extension
     * @return mixed
     */
    public function install($extension)
    {
        $this->dispatch(new InstallExtension($extension));
    }

    /**
     * Uninstall a extension.
     *
     * @param  $extension
     * @return mixed
     */
    public function uninstall($extension)
    {
        $this->dispatch(new UninstallExtension($extension));
    }

    /**
     * Sync extensions to the database.
     */
    public function sync()
    {
        $this->dispatch(new SyncExtensions());
    }
}
