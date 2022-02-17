<?php

namespace Streams\Core\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Images
 *
 * @property Streams\Core\Image\ImagePaths $paths
 * @property Streams\Core\Image\ImageRegistry $registry
 * @method static \Streams\Core\Image\Image make($source)
 * @method static \Streams\Core\Image\ImageManager register(string $name, $image)
 * @method static \Streams\Core\Image\ImageManager addPath(string $namespace, string $path)
 * @method static \Streams\Core\Image\ImageManager resolve($image)
 * @method static \Streams\Core\Image\ImageManager newRemoteImage(array $attributes)
 * @method static \Streams\Core\Image\ImageManager newStorageImage(array $attributes)
 * @method static \Streams\Core\Image\ImageManager newLocalImage(array $attributes)
 */
class Images extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'images';
    }
}
