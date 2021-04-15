<?php

namespace Streams\Core\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Streams\Core\Image\ImageRegistry;
use Streams\Core\Image\Type\LocalImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Image\Type\RemoteImage;
use Streams\Core\Image\Type\StorageImage;
use Streams\Core\Support\Traits\FiresCallbacks;

class ImageManager
{

    use Macroable;
    use FiresCallbacks;

    /**
     * Image path hints by namespace.
     *
     * @var ImagePaths
     */
    protected $paths;

    /**
     * The image registry.
     *
     * @var ImageRegistry
     */
    protected $registry;

    /**
     * Create a new Image instance.
     *
     * @param ImagePaths $paths
     * @param ImageRegistry $registry
     */
    public function __construct(ImagePaths $paths, ImageRegistry $registry)
    {
        $this->paths    = $paths;
        $this->registry = $registry;
    }

    /**
     * Make a new image instance.
     *
     * @param  mixed $source
     * @return Image
     */
    public function make($source)
    {
        $attributes = is_array($source) ? $source : compact('source');

        $attributes['original'] = basename($attributes['source']);

        if (is_string($attributes['source'])) {
            $attributes['source'] = $this->resolve($attributes['source']);
        }

        /**
         * If the file is remote then
         * use the path it resides in.
         */
        if (
            !isset($attributes['type'])
            && is_string($attributes['source'])
            && Str::startsWith($attributes['source'], ['http://', 'https://', '//'])
        ) {
            $attributes['type'] = 'remote';
        }

        /**
         * If the image is a disk file
         * AND using the storage system.
         */
        if (
            !isset($attributes['type'])
            && is_string($attributes['source'])
            && Str::is('*://*', $attributes['source'])
        ) {
            $attributes['type'] = 'storage';
        }

        /**
         * If the image is a local filed
         * AND using the storage system.
         */
        if (
            !isset($attributes['type'])
            && is_string($attributes['source'])
            && Storage::disk('public')->exists($attributes['source'])
        ) {
            $attributes['type'] = 'storage';
        }

        /**
         * If the image is a local file
         * not using the storage system.
         */
        if (
            !isset($attributes['type'])
            && is_string($attributes['source'])
            && File::exists(base_path($attributes['source']))
        ) {
            $attributes['type'] = 'local';
        }

        /**
         * Allow others to manipulate
         * the attributes and image type.
         */
        $this->fire('make', ['attributes' => $attributes = collect($attributes)]);

        if (!$attributes->has('type')) {
            throw new \Exception('Unable to determine image type.');
        }

        $method = Str::camel(implode('_', [
            'new',
            $attributes->get('type'),
            'image',
        ]));

        $image = $this->{$method}($attributes->all());

        /**
         * It is done. Give others a chance to
         * alter the image before getting started.
         */
        $this->fire('make', ['image' => $image]);

        return $image;
    }

    /**
     * Register a named image.
     *
     * @param string $name
     * @param mixed $image
     * @return $this
     */
    public function register($name, $image)
    {
        $this->registry->register($name, $image);

        return $this;
    }

    /**
     * Add a path hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Resolve a hinted/named image.
     *
     * @param $image
     * @return string|null
     */
    protected function resolve($image)
    {
        return ltrim(str_replace(base_path(), '', $this->paths->real(
            $this->registry->resolve($image) ?: $image
        )), '/\\');
    }

    /**
     * Return a new remote image.
     *
     * @param array $attributes
     * @return RemoteImage
     */
    public function newRemoteImage(array $attributes)
    {
        return new RemoteImage($attributes);
    }

    /**
     * Return a new storage image.
     *
     * @param array $attributes
     * @return StorageImage
     */
    public function newStorageImage(array $attributes)
    {
        return new StorageImage($attributes);
    }

    /**
     * Return a new local image.
     *
     * @param array $attributes
     * @return LocalImage
     */
    public function newLocalImage(array $attributes)
    {
        return new LocalImage($attributes);
    }
}
