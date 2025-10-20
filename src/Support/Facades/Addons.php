<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Addons
 * Alias AddonManage
 *
 * @method void install(string $addonName) Install the specified addon.
 * @method void uninstall(string $addonName) Uninstall the specified addon.
 * @method bool isInstalled(string $addonName) Check if the addon is installed.
 * @method array listAddons() Get a list of all available addons.
 * @method void enable(string $addonName) Enable the specified addon.
 * @method void disable(string $addonName) Disable the specified addon.
 */
class Addons extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'addons';
    }
}
