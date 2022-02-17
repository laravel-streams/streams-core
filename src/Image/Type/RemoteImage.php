<?php

namespace Streams\Core\Image\Type;

use Streams\Core\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

class RemoteImage extends LocalImage
{

    public function lastModified(): int
    {
        try {
            return filemtime($this->source);
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function intervention(): InterventionImage
    {
        return ImageManagerStatic::make($this->source);
    }

    protected function output(): Image
    {
        $output = $this->attributes;

        $path = parse_url($this->source)['path'];

        $output['source'] = ltrim(str_replace(base_path(), '', public_path('app/' . ltrim(dirname($path) . '/' . $this->filename(), '/\\'))), '/\\');

        return new self($output);
    }

    public function data(): string
    {
        return file_get_contents($this->source);
    }
}
