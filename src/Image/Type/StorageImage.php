<?php

namespace Streams\Core\Image\Type;

use Streams\Core\Image\Image;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

class StorageImage extends Image
{
    public function __construct(array $attributes)
    {
        list($disk, $path) = explode('://', $attributes['source']);

        $attributes['disk'] = $disk;
        $attributes['path'] = $path;

        parent::__construct($attributes);
    }

    public function assetUrl(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function exists(): bool
    {
        return Storage::disk($this->disk)->exists($this->path);
    }

    public function save(InterventionImage $intervention): void
    {
        Storage::disk($this->disk)->put($this->path, $intervention->encode($this->extension(), $this->quality)->encoded);
    }

    public function size(): int
    {
        return Storage::disk($this->disk)->size($this->path);
    }

    public function lastModified(): int
    {
        return Storage::disk($this->disk)->lastModified($this->path);
    }

    protected function intervention(): InterventionImage
    {
        return ImageManagerStatic::make(Storage::disk($this->disk)->get($this->path));
    }

    protected function output(): Image
    {
        return new static([
            'source' => 'public://' . dirname($this->path) . '/' . $this->filename(),
        ]);
    }

    public function data(): string
    {
        return Storage::disk($this->disk)->get($this->path);
    }
}
