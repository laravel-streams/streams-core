<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Provider\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonServiceProvider extends ServiceProvider
{

    /**
     * Register the addon.
     */
    public function register()
    {
        $this->registerAddon();
        $this->registerCommon();
    }

    /**
     * Register the addon instance.
     */
    protected function registerAddon()
    {
        //dd('Test');
    }
}
