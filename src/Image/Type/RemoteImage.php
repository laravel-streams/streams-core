<?php

namespace Streams\Core\Image\Type;

use Illuminate\Support\Arr;
use Streams\Core\Image\Image;
use Intervention\Image\ImageManagerStatic;
use Intervention\Image\Image as InterventionImage;

class RemoteImage extends Image
{
    public function assetUrl(): string
    {
        return $this->source;
    }

    public function exists(): bool
    {
        $ch = curl_init($this->source);

        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($status == 200) {
            return true;
        }

        return false;
    }

    public function size(): int
    {
        $headers = get_headers($this->source, 1);

        return $headers['Content-Length'];
    }

    public function lastModified(): int
    {
        $headers = get_headers($this->source, 1);

        if ($modified = Arr::get($headers, 'Last-Modified')) {
            $modified = strtotime($modified);
        }

        return $modified ?: 0;
    }

    protected function intervention(): InterventionImage
    {
        return ImageManagerStatic::make($this->source);
    }

    protected function output(): Image
    {
        return $this;
        // $output = $this->attributes;

        // $path = parse_url($this->source)['path'];

        // $output['source'] = ltrim(str_replace(base_path(), '', public_path('app/' . ltrim(dirname($path) . '/' . $this->filename(), '/\\'))), '/\\');

        // return new self($output);
    }

    public function save(InterventionImage $intervention): void
    {
        // Remote images do not get saved.
    }

    public function data(): string
    {
        return file_get_contents($this->source);
    }
}
