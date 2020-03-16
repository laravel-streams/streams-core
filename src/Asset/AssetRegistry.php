<?php

namespace Anomaly\Streams\Platform\Asset;

/**
 * Class AssetRegistry
 *
 * @link       http://pyrocms.com/
 * @author     PyroCMS, Inc. <support@pyrocms.com>
 * @author     Ryan Thompson <ryan@pyrocms.com>
 */
class AssetRegistry
{

    /**
     * Predefined paths.
     *
     * @var array
     */
    protected $assets = [];

    /**
     * Register assets.
     *
     * @param string $name
     * @param array $assets
     */
    public function register($name, $assets)
    {
        $this->assets[$name] = (array)$assets;
    }

    /**
     * Resolve assets.
     *
     * @param string $name
     * @param string|array $default
     * @return array
     */
    public function resolve($name, $default = [])
    {
        return (array) array_get($this->assets, $name, (array)$default);
    }
}
