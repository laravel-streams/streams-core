<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Facades\Artisan;
use Anomaly\Streams\Platform\Addon\Event\AddonWasInstalled;
use Anomaly\Streams\Platform\Addon\Event\AddonWasUninstalled;
use Anomaly\Streams\Platform\Addon\Module\Event\ModuleWasMigrated;
use Anomaly\Streams\Platform\Addon\Contract\AddonRepositoryInterface;

/**
 * Class AddonManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonManager
{

    /**
     * Install an addon.
     *
     * @param Addon $addon
     * @param bool   $seed
     * @return bool
     */
    public function install(Addon $addon, $seed = false)
    {
        $addon->fire('installing', ['addon' => $addon]);

        $options = [
            'addon' => $addon->getNamespace(),
        ];

        Artisan::call('addon:migrate', $options);

        app(AddonRepositoryInterface::class)->install($addon);

        if ($seed) {
            Artisan::call('addon:seed', $options);
        }

        $addon->fire('installed', ['addon' => $addon]);

        event(new AddonWasInstalled($addon));

        return true;
    }

    /**
     * Uninstall an addon.
     *
     * @param Addon $addon
     */
    public function uninstall(Addon $addon)
    {
        $addon->fire('uninstalling', ['addon' => $addon]);

        $options = [
            'addon' => $addon->getNamespace(),
        ];

        Artisan::call('addon:reset', $options);

        app(AddonRepositoryInterface::class)->uninstall($addon);

        $addon->fire('uninstalled', ['addon' => $addon]);

        event(new AddonWasUninstalled($addon));

        return true;
    }

    /**
     * Enable an addon.
     *
     * @param Addon $addon
     * @return bool
     */
    public function enable(Addon $addon)
    {
        return app(AddonRepositoryInterface::class)->enable($addon);
    }

    /**
     * Disable an addon.
     *
     * @param Addon $addon
     */
    public function disable(Addon $addon)
    {
        return app(AddonRepositoryInterface::class)->disable($addon);
    }

    /**
     * Migrate a module.
     *
     * @param Addon $addon
     * @param bool   $seed
     */
    public function migrate(Addon $addon)
    {
        $addon->fire('migrating', ['addon' => $addon]);

        $options = [
            '--realpath' => true,
            '--path' => $addon->getPath('migrations'),
        ];

        Artisan::call('migrate', $options);

        $addon->fire('migrated', ['addon' => $addon]);

        event(new ModuleWasMigrated($addon));

        return true;
    }
}
