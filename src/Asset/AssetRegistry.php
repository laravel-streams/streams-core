<?php

namespace Streams\Core\Asset;

use Illuminate\Support\Arr;

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
        $this->assets[$name] = $assets;
    }

    /**
     * Resolve assets.
     *
     * @param string $name
     * @return array
     */
    public function resolve($name)
    {
        return Arr::get($this->assets, $name, $name);
    }
}
