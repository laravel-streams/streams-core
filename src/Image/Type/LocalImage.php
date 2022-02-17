<?php

namespace Streams\Core\Image\Type;

use Streams\Core\Image\Image;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

class LocalImage extends Image
{
    public function assetUrl(): string
    {
        return str_replace(public_path(), '', base_path($this->source));
    }

    public function exists(): bool
    {
        return File::exists(base_path($this->source));
    }

    public function size(): int
    {
        return File::size(base_path($this->source));
    }

    public function lastModified(): int
    {
        return File::lastModified(base_path($this->source));
    }

    protected function output(): Image
    {
        $output = $this->attributes;

        $output['source'] = ltrim(str_replace(base_path(), '', public_path('app/' . dirname($this->source) . '/' . $this->filename())), '/\\');

        return new self($output);
    }

    protected function intervention(): InterventionImage
    {
        return ImageManagerStatic::make(base_path($this->source));
    }

    public function save(InterventionImage $intervention): void
    {
        if (!File::isDirectory($directory = dirname($path = base_path($this->source)))) {
            File::makeDirectory($directory, 0755, true);
        }

        File::put($path, $intervention->encode($this->extension(), $this->quality)->encoded);
    }

    public function data(): string
    {
        return file_get_contents(base_path($this->source));
    }
}
