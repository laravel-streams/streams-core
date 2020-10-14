<?php

namespace Streams\Core\Image\Type;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Streams\Core\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

/**
 * Class StorageImage
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StorageImage extends Image
{

    /**
     * Create a new StorageImage instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        if (!Str::is('*://*', $attributes['source'])) {
            $attributes['source'] = 'public://' . ltrim($attributes['source'], '/\\');
        }

        list($disk, $path) = explode('://', $attributes['source']);

        $attributes['disk'] = $disk;
        $attributes['path'] = $path;

        parent::__construct($attributes);
    }

    /**
     * Return the asset URL.
     * 
     * @return string
     */
    public function assetUrl()
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /**
     * Return if the image exists.
     * 
     * @return bool
     */
    public function exists()
    {
        return Storage::disk($this->disk)->exists($this->path);
    }

    /**
     * Save the contents of the image.
     * 
     * @param InterventionImage $intervention
     */
    public function save(InterventionImage $intervention)
    {
        Storage::disk($this->disk)->put($this->path, $intervention->encode($this->extension(), $this->quality)->encoded);
    }

    /**
     * Return the image size.
     * 
     * return int
     */
    public function size()
    {
        return Storage::disk($this->disk)->size($this->path);
    }

    /**
     * Return the last modified timestamp.
     * 
     * @return int
     */
    public function lastModified()
    {
        return Storage::disk($this->disk)->lastModified($this->path);
    }

    /**
     * Return an Intervention instance.
     *
     * @return InterventionImage
     */
    protected function intervention()
    {
        return ImageManagerStatic::make(Storage::disk($this->disk)->get($this->path));
    }

    /**
     * Return the output image instance.
     *
     * @return Image
     */
    protected function output()
    {
        $output = $this->attributes;

        $output['source'] = dirname($this->path) . '/' . $this->filename();

        return new self($output);
    }
}
