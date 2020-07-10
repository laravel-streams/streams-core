<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Anomaly\Streams\Platform\Support\Facades\Assets;

/**
 * Trait RegistersAssets
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersAssets
{

    /**
     * The named assets.
     *
     * @var array
     */
    public $assets = [];

    /**
     * Register the named assets.
     */
    protected function registerAssets()
    {
        foreach ($this->assets as $name => $assets) {
            Assets::register($name, $assets);
        }
    }
}
