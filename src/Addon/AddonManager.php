<?php

namespace Anomaly\Streams\Platform\Addon;

use Illuminate\Support\Facades\Artisan;
use Anomaly\Streams\Platform\Addon\Event\AddonWasReset;
use Anomaly\Streams\Platform\Addon\Event\AddonWasSeeded;
use Anomaly\Streams\Platform\Addon\Event\AddonWasMigrated;
use Anomaly\Streams\Platform\Addon\Event\AddonWasInstalled;
use Anomaly\Streams\Platform\Addon\Event\AddonWasUninstalled;
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

    protected $repository;

    /**
     * Creatae a new AddonManager class.
     *
     * @param AddonRepositoryInterface $repository
     */
    public function __construct(AddonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

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

        $this->migrate($addon);

        $this->repository->install($addon);

        $this->seed($addon);

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

        $this->reset($addon);

        $this->repository->uninstall($addon);

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
        return $this->repository->enable($addon);
    }

    /**
     * Disable an addon.
     *
     * @param Addon $addon
     */
    public function disable(Addon $addon)
    {
        return $this->repository->disable($addon);
    }

    /**
     * Migrate an addon.
     *
     * @param Addon $addon
     * @return bool
     */
    public function migrate(Addon $addon)
    {
        if (!is_dir($path = $addon->getPath('migrations'))) {
            return false;
        }

        $addon->fire('migrating', ['addon' => $addon]);

        $options = [
            '--realpath' => true,
            '--path' => $path,
        ];

        Artisan::call('migrate', $options);

        $addon->fire('migrated', ['addon' => $addon]);

        event(new AddonWasMigrated($addon));

        return true;
    }

    /**
     * Reset an addon.
     *
     * @param Addon $addon
     * @return bool
     */
    public function reset(Addon $addon)
    {
        $addon->fire('resetting', ['addon' => $addon]);

        $options = [
            '--realpath' => true,
            '--path' => $addon->getPath('migrations'),
        ];

        Artisan::call('migrate:reset', $options);

        $addon->fire('reset', ['addon' => $addon]);

        event(new AddonWasReset($addon));

        return true;
    }

    /**
     * Seed an addon.
     *
     * @param Addon $addon
     * @return bool
     */
    public function seed(Addon $addon)
    {
        if (!class_exists($class = get_class($addon) . 'Seeder')) {
            return false;
        }

        $addon->fire('seeding', ['addon' => $addon]);

        $options = [
            '--class' => $class,
        ];

        Artisan::call('db:seed', $options);

        $addon->fire('seeded', ['addon' => $addon]);

        event(new AddonWasSeeded($addon));

        return true;
    }
}
