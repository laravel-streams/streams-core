<?php

namespace Streams\Core\Image\Type;

use Streams\Core\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

/**
 * Class RemoteImage
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RemoteImage extends LocalImage
{

    /**
     * Return the last modified timestamp.
     * 
     * @return int
     */
    public function lastModified()
    {
        try {
            return filemtime($this->source);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Return the output image instance.
     *
     * @return Image
     */
    protected function output()
    {
        $output = $this->attributes;

        $path = parse_url($this->source)['path'];

        $output['source'] = ltrim(str_replace(base_path(), '', public_path('app/' . ltrim(dirname($path) . '/' . $this->filename(), '/\\'))), '/\\');

        return new self($output);
    }

    /**
     * Return an Intervention instance.
     *
     * @return InterventionImage
     */
    protected function intervention()
    {
        return ImageManagerStatic::make($this->source);
    }
}
