<?php

namespace Streams\Core\Image\Type;

use Illuminate\Support\Facades\File;
use Streams\Core\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

/**
 * Class LocalImage
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class LocalImage extends Image
{

    /**
     * Return the image asset URL.
     * 
     * @return string
     */
    public function assetUrl()
    {
        return str_replace(public_path(), '', base_path($this->source));
    }

    /**
     * Return if the image exists.
     * 
     * @return bool
     */
    public function exists()
    {
        return File::exists(base_path($this->source));
    }

    /**
     * Return the image size.
     * 
     * return int
     */
    public function size()
    {
        return File::size(base_path($this->source));
    }

    /**
     * Return the last modified timestamp.
     * 
     * @return int
     */
    public function lastModified()
    {
        return File::lastModified(base_path($this->source));
    }

    /**
     * Return the output image instance.
     *
     * @return Image
     */
    protected function output()
    {
        $output = $this->attributes;

        $output['source'] = ltrim(str_replace(base_path(), '', public_path('app/' . dirname($this->source) . '/' . $this->filename())), '/\\');

        return new self($output);
    }

    /**
     * Return an Intervention instance.
     *
     * @return InterventionImage
     */
    protected function intervention()
    {
        return ImageManagerStatic::make(base_path($this->source));
    }

    /**
     * Save the contents of the image.
     * 
     * @param InterventionImage $intervention
     */
    public function save(InterventionImage $intervention)
    {
        if (!File::isDirectory($directory = dirname($path = base_path($this->source)))) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($path, $intervention->encode($this->extension(), $this->quality)->encoded);
    }
}
