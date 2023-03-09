<?php

namespace Streams\Core\Image;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Streams\Core\Image\ImageRegistry;
use Streams\Core\Image\Type\LocalImage;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Image\Type\RemoteImage;
use Streams\Core\Image\Type\StorageImage;
use Streams\Core\Support\Traits\FiresCallbacks;

class ImageManager
{

    use Macroable;
    use FiresCallbacks;

    public function __construct(
        protected ImagePaths $paths,
        protected ImageRegistry $registry
    ) {
    }

    public function make(string|array $source): Image
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
        // if (
        //     !isset($attributes['type'])
        //     && is_string($attributes['source'])
        //     && Storage::disk('public')->exists($attributes['source'])
        // ) {
        //     $attributes['type'] = 'storage';
        // }

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

        $this->fire('ready', ['image' => $image]);

        return $image;
    }

    public function register(string $name, string $image): static
    {
        $this->registry->register($name, $image);

        return $this;
    }

    public function addPath(string $namespace, string $path): static
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    public function newRemoteImage(array $attributes): RemoteImage
    {
        return new RemoteImage($attributes);
    }

    public function newStorageImage(array $attributes): StorageImage
    {
        return new StorageImage($attributes);
    }

    public function newLocalImage(array $attributes): LocalImage
    {
        return new LocalImage($attributes);
    }

    protected function resolve(string $image): string
    {
        return ltrim(str_replace(base_path(), '', $this->paths->real(
            $this->registry->resolve($image) ?: $image
        )), '/\\');
    }
}
