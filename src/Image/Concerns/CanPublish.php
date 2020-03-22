<?php

namespace Anomaly\Streams\Platform\Image\Concerns;

use League\Flysystem\MountManager;
use Illuminate\Support\Facades\File;
use Anomaly\Streams\Platform\Image\ImageManager;
use Intervention\Image\ImageManager as Intervention;

/**
 * Trait CanPublish
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanPublish
{
    
    /**
     * Get the cache path of the image.
     *
     * @return string
     */
    protected function getCachePath()
    {
        if (starts_with($this->source, ['http://', 'https://', '//'])) {
            return $this->source;
        }

        $output = $this->outputPath();

        try {
            if ($this->shouldPublish($output)) {
                $this->publish($output);
            }
        } catch (\Exception $e) {
            return config('app.debug', false) ? $e->getMessage() : null;
        }

        if (config('streams::images.version') && $this->getVersion() !== false) {
            $output .= '?v=' . filemtime(public_path(trim($output, '/\\')));
        }
        return $output;
    }

    /**
     * Return the output path for an image.
     *
     * @param $path
     * @return string
     */
    public function outputPath()
    {
        
        /*
         * If the path is already public
         * and we don't have alterations
         * then just use it as it is.
         */
        if (
            str_contains($this->source, public_path())
            && !$this->hasAlterations()
            && !$this->getQuality()
            ) {
            return str_replace(public_path(), '', $this->source);
        }

        /**
         * If renaming then this has already
         * been provided by the filename.
         */
        if ($rename = $this->getFilename()) {
            return ltrim($rename, '/\\');
        }

        /*
         * If the path is a file or file path then
         * put it in /app/files/disk/folder/filename.ext
         */
        if (is_string($this->source) && str_is('*://*', $this->source)) {
            
            list($disk, $folder, $filename) = explode('/', str_replace('://', '/', $this->source));

            if ($this->hasAlterations() || $this->getQuality()) {
                $filename = md5(
                    var_export([$this->source, $this->getAlterations()], true) . $this->getQuality()
                ) . '.' . $this->extension();
            }

            if ($rename = $this->getFilename()) {
                
                $filename = $rename;

                if (strpos($filename, DIRECTORY_SEPARATOR)) {
                    $directory = null;
                }
            }

            return "/img/{$disk}/{$folder}/{$filename}";
        }

        /*
         * Get the real path relative to our installation.
         */
        $source = str_replace(base_path(), '', app(ImageManager::class)->resolve($this->source));

        /*
         * Build out path parts.
         */
        $filename    = basename($source);
        $directory   = ltrim(dirname($source), '/\\') . '/';

        if ($this->getAlterations() || $this->getQuality()) {
            $filename = md5(
                var_export([$source, $this->getAlterations()], true) . $this->getQuality()
            ) . '.' . $this->getExtension();
        }

        return "/{$directory}{$filename}";
    }

    /**
     * Determine if the image needs to be published
     *
     * @param $path
     * @return bool
     */
    private function shouldPublish($path)
    {
        $path = ltrim($path, '/');
        $resolved = app(ImageManager::class)->resolve($path);

        if (!File::exists($path)) {
            return true;
        }

        if (is_string($this->source) && !str_is('*://*', $this->source) && filemtime($path) < filemtime($resolved)) {
            return true;
        }

        if (
            is_string($this->source) && str_is('*://*', $this->source) && filemtime($path) < app(
                'League\Flysystem\MountManager'
            )->getTimestamp($resolved)
        ) {
            return true;
        }

        // if ($this->source instanceof FileInterface && filemtime($path) < $this->source->lastModified()->format('U')) {
        //     return true;
        // }

        return false;
    }

    /**
     * Publish an image to the publish directory.
     *
     * @param $path
     * @return void
     */
    protected function publish($path)
    {

        File::makeDirectory(dirname(public_path($path)), 0755, true, true);

        if (!in_array($this->extension(), [
            'gif',
            'jpeg',
            'jpg',
            'jpe',
            'png',
            'webp',
        ])) {
            return File::put(public_path($path), app(ImageManager::class)->read($this->source));
        }
        
        /**
         * @var Intervention $image
         */
        if (!$image = $this->intervention()) {
            return false;
        }
        
        if (function_exists('exif_read_data') && $image->exif('Orientation') && $image->exif('Orientation') > 1) {
            $this->addAlteration('orientate');
        }

        if (in_array($this->getExtension(), ['jpeg', 'jpg']) && config('streams::images.interlace')) {
            $this->addAlteration('interlace');
        }

        if (!$this->getAlterations() && !$this->getQuality()) {
            return $image->save(public_path($path), $this->getQuality() ?: config('streams::images.quality', 80));
        }

        if (is_callable('exif_read_data') && in_array('orientate', $this->getAlterations())) {
            $this->setAlterations(array_unique(array_merge(['orientate'], $this->getAlterations())));
        }

        foreach ($this->getAlterations() as $method => $arguments) {
            if (is_array($arguments)) {
                call_user_func_array([$image, $method], $arguments);
            } else {
                call_user_func([$image, $method], $arguments);
            }
        }

        $image->save(public_path($path), $this->getQuality() ?: config('streams::images.quality', 80));
    }

    /**
     * Make an image instance.
     *
     * @return Intervention
     */
    protected function intervention()
    {
        // if ($this->source instanceof FileInterface) {
        //     return app(intervention::class)->make(app(MountManager::class)->read($this->source->location()));
        // }

        if (is_string($this->source) && str_is('*://*', $this->source)) {
            return app(intervention::class)->make(app(MountManager::class)->read($this->source));
        }

        // if ($this->source instanceof File) {
        //     return app(intervention::class)->make($this->source->read());
        // }

        if (is_string($this->source) && file_exists($resolved = app(ImageManager::class)->resolve($this->source))) {
            return app(intervention::class)->make($resolved);
        }

        if ($this->source instanceof Intervention) {
            return $this->source;
        }

        return null;
    }
}
