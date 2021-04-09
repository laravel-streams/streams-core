<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Assets
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @property array                             $collections
 * @property array                             $resolved
 * @property \Collective\Html\HtmlBuilder      $html
 * @property \Illuminate\Filesystem\Filesystem $files
 * @property \Streams\Core\Asset\AssetPaths    $paths
 * @property \Streams\Core\Asset\AssetRegistry $registry
 * @method static \Streams\Core\Asset\AssetCollection collection(string $name)
 * @method static \Streams\Core\Asset\AssetManager register(string $name, $assets)
 * @method static \Streams\Core\Asset\AssetManager inline($asset)
 * @method static \Streams\Core\Asset\AssetManager contents($asset)
 * @method static \Streams\Core\Asset\AssetManager url(string $asset, array $parameters = [], $secure = null)
 * @method static \Streams\Core\Asset\AssetManager tag(string $name, array $attributes = [])
 * @method static \Streams\Core\Asset\AssetManager script($asset, array $attributes = [], $content = null)
 * @method static \Streams\Core\Asset\AssetManager style($asset, array $attributes = [], $content = null)
 * @method static \Streams\Core\Asset\AssetManager resolve($asset)
 * @method static \Streams\Core\Asset\AssetManager addPath(string $namespace, string $path)
 * @method static \Streams\Core\Asset\AssetManager realPath($asset)
 */
class Assets extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'assets';
    }
}
