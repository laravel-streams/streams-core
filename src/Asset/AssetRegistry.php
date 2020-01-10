<?php

namespace Anomaly\Streams\Platform\Asset;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;

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
    protected static $assets = [];

    /**
     * Register assets.
     *
     * @param array $assets
     */
    public static function register($assets)
    {
        self::$assets = array_merge_recursive(self::$assets, $assets);
    }

    /**
     * Resolve assets.
     *
     * @param array $asset
     */
    public static function resolve($asset)
    {
        return (array) array_get(self::$assets, $asset, $asset);
    }
}
