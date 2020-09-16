<?php

namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Support\Facades\Images;
use Intervention\Image\ImageManager as Intervention;
use Anomaly\Streams\Platform\Support\Traits\Properties;

/**
 * Class Image
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Image
{
    use Macroable;
    use Properties;

    /**
     * Set the filename.
     *
     * @param $filename
     * @return $this
     */
    public function rename($filename = null)
    {
        return $this->setAttribute('filename', $filename);
    }

    /**
     * Return a source tag.
     *
     * @param array $attributes
     * @return string
     */
    public function source(array $attributes = [])
    {
        $attributes = array_merge($this->attributes(['srcset' => $this->srcset() ?: $this->path()]), $attributes);

        return '<source' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Return if the Image is remote or not.
     *
     * @return bool
     */
    public function isRemote()
    {
        return is_string($this->source) && Str::startsWith($this->source, ['http://', 'https://', '//']);
    }

    /**
     * Add an alteration.
     *
     * @param  $method
     * @param  array $arguments
     * @return $this
     */
    public function addAlteration($method, $arguments = [])
    {
        if ($method == 'resize') {
            $this->guessResizeArguments($arguments);
        }

        $alterations = $this->alterations;
        
        $alterations[$method] = $arguments;

        $this->alterations = $alterations;

        return $this;
    }

    /**
     * Guess the resize callback value
     * from a boolean.
     *
     * @param array $arguments
     */
    private function guessResizeArguments(array &$arguments)
    {
        $arguments = array_pad($arguments, 3, null);

        if (end($arguments) instanceof \Closure) {
            return;
        }

        if (array_pop($arguments) !== false) {
            $arguments[] = function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            };
        }
    }

    /**
     * Get the cache path of the image.
     *
     * @return string
     */
    protected function getCachePath()
    {
        $source = Images::path($this->source);

        if (Str::startsWith($source, ['http://', 'https://', '//'])) {
            return $source;
        }

        $output = $this->outputPath($source);

        try {
            if ($this->shouldPublish($output)) {
                $this->publish($output);
            }
        } catch (\Exception $e) {
            return Config::get('app.debug', false) ? $e->getMessage() : null;
        }

        if (Config::get('streams.images.version') && $this->version !== false) {
            $output .= '?v=' . filemtime($output);
        }

        return str_replace(public_path(), '', $output);
    }

    /**
     * Return the output path for an image.
     *
     * @param $path
     * @return string
     */
    protected function outputPath($path)
    {

        /*
         * If the path is already public
         * and we don't have alterations
         * then just use it as it is.
         */
        if (
            is_string($this->source)
            && Str::contains($this->source, [public_path(), 'public::'])
            && !$this->alterations
            && !$this->quality
        ) {
            return $this->source;
        }

        /*
         * If the path is already public
         * and we DO have alterations
         * then use the assets dir.
         */
        if (
            is_string($this->source)
            && Str::contains($this->source, [public_path(), 'public::'])
            && ($this->alterations || $this->quality)
        ) {
            return public_path('assets/' . str_replace([public_path(), 'public::'], '', $this->source));
        }

        /**
         * If renaming then this has already
         * been provided by the filename.
         */
        if ($rename = $this->filename) {
            return public_path('assets/' . ltrim($rename, '/\\'));
        }

        /*
         * If the path is a file or file path then
         * put it in /app/files/disk/folder/filename.ext
         */
        if (is_string($this->source) && Str::is('*://*', $this->source)) {

            list($disk, $folder, $filename) = explode('/', str_replace('://', '/', $this->source));

            if ($this->alterations || $this->quality) {
                $filename = md5(
                    var_export([$this->source, $this->alterations], true) . $this->quality
                ) . '.' . $this->extension();
            }

            if ($rename = $this->filename) {

                $filename = $rename;

                if (strpos($filename, DIRECTORY_SEPARATOR)) {
                    $directory = null;
                }
            }

            return public_path("assets/img/{$disk}/{$folder}/{$filename}");
        }

        /*
         * Get the real path relative to our installation.
         */
        $source = str_replace(base_path(), '', $path);

        /*
         * Build out path parts.
         */
        $filename    = basename($source);
        $directory   = ltrim(dirname($source), '/\\') . '/';

        if ($this->alterations || $this->quality) {
            $filename = md5(
                var_export([$source, $this->alterations], true) . $this->quality
            ) . '.' . $this->extension();
        }

        return public_path("assets/{$directory}{$filename}");
    }

    /**
     * Return the image extension.
     *
     * @return string
     */
    public function extension()
    {
        if ($this->extension) {
            return $this->extension;
        }

        return $this->extension = pathinfo($this->source, PATHINFO_EXTENSION);
    }

    /**
     * Determine if the image needs to be published
     *
     * @param $path
     * @return bool
     */
    private function shouldPublish($path)
    {
        $resolved = Images::path($path);

        if (!File::exists($resolved)) {
            return true;
        }

        if (
            is_string($this->source)
            && str_contains($this->source, public_path())
            && !$this->alterations
            && !$this->quality
        ) {
            return false;
        }

        if (
            is_string($this->source)
            && str_contains($this->source, public_path())
            && !str_contains($this->source, public_path('assets'))
        ) {
            return true;
        }

        if (is_string($this->source) && !Str::is('*://*', $this->source) && filemtime($resolved) < filemtime($resolved)) {
            return true;
        }

        if (
            is_string($this->source) && Str::is('*://*', $this->source) && filemtime($resolved) < app(
                'League\Flysystem\MountManager'
            )->getTimestamp($resolved)
        ) {
            return true;
        }

        // if ($this->source instanceof FileInterface && filemtime($resolved) < $this->source->lastModified()->format('U')) {
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

        File::makeDirectory(dirname($path), 0755, true, true);
        
        if (!in_array($this->extension(), [
            'gif',
            'jpeg',
            'jpg',
            'jpe',
            'png',
            'webp',
        ])) {
            return File::put($path, File::get(Images::path($this->source)));
        }

        /**
         * @var Intervention $image
         */
        if (!$image = $this->intervention()) {
            return false;
        }

        // if (function_exists('exif_read_data') && $image->exif('Orientation') && $image->exif('Orientation') > 1) {
        //     //$this->addAlteration('orientate');
        // }

        // if (in_array($this->extension(), ['jpeg', 'jpg']) && Config::get('streams.images.interlace')) {
        //     //$this->addAlteration('interlace');
        // }

        if (!$this->alterations && !$this->quality) {
            return $image->save($path, $this->quality ?: Config::get('streams.images.quality', null));
        }

        // if (is_callable('exif_read_data') && in_array('orientate', $this->alterations)) {
        //     $this->setAlterations(array_unique(array_merge(['orientate'], $this->alterations)));
        // }

        foreach ($this->alterations as $method => $arguments) {
            if (is_array($arguments)) {
                call_user_func_array([$image, $method], $arguments);
            } else {
                call_user_func([$image, $method], $arguments);
            }
        }

        $image->save($path, $this->quality ?: Config::get('streams.images.quality', null));
    }

    /**
     * Make an image instance.
     *
     * @return Intervention
     */
    protected function intervention()
    {
        if (is_string($this->source) && Str::is('*://*', $this->source)) {
            return app(intervention::class)->make(app(MountManager::class)->read($this->source));
        }

        if (is_string($this->source) && file_exists($path = Images::path($this->source))) {
            return app(intervention::class)->make($path);
        }

        if ($this->source instanceof Intervention) {
            return $this->source;
        }

        return null;
    }

    /**
     * Return the image tag to an image.
     *
     * @param  null $alt
     * @param  array $attributes
     * @return string
     */
    public function img($alt = null, array $attributes = [])
    {
        $attributes = array_merge((array)$this->attr('attributes', []), $attributes);

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->url();
        }

        if ($srcset = $this->srcsets) {
            $attributes['srcset'] = $srcset;
        }

        if (!$alt && !isset($attributes['alt']) && Config::get('streams.images.auto_alt', true)) {

            $original = $this->attr('original');

            $attributes['alt'] = Arr::get(
                $this->attributes,
                'alt',
                ucwords(
                    Str::humanize(
                        trim(basename(
                            $original,
                            pathinfo($original, PATHINFO_EXTENSION)
                        ), '.'),
                        '^a-zA-Z0-9'
                    )
                )
            );
        }

        return '<img' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Return a picture tag.
     *
     * @return string
     */
    public function picture(array $attributes = [])
    {
        $sources = implode("\n", array_map(function ($source) {
            return $source->source();
        }, $this->sources));

        $sources .= "\n" . $this->img($attributes);

        return "<picture>\n{$sources}\n</picture>";
    }

    /**
     * Encode the image.
     *
     * @param  null $format
     * @param  int $quality
     * @return $this
     */
    public function encode($format = null, $quality = null)
    {
        $this->quality = $quality;
        $this->extension = $format;
        $this->addAlteration('encode');

        return $this;
    }

    /**
     * Return the base64_encoded image source.
     *
     * @return string
     */
    public function base64()
    {
        $extension = $this->extension();

        if ($extension == 'svg') {
            $extension = 'svg+xml';
        }

        return 'data:image/' . $extension . ';base64,' . base64_encode($this->data());
    }

    /**
     * Return the URL to an image.
     *
     * @param  array $parameters
     * @param  null $secure
     * @return string
     */
    public function url(array $parameters = [], $secure = null)
    {
        $parameters = $parameters ? '?' . http_build_query($parameters) : null;

        return URL::asset($this->getCachePath().$parameters, $secure);
    }

    /**
     * Return the path to an image.
     *
     * @return string
     */
    public function path()
    {
        return Request::getBasePath() . $this->getCachePath();
    }

    /**
     * Return the image tag to a
     * data encoded inline image.
     *
     * @param  null $alt
     * @param  array $attributes
     * @return string
     */
    public function inline($alt = null, array $attributes = [])
    {
        $attributes['src'] = $this->base64();

        return $this->img($alt, $attributes);
    }

    /**
     * Return the CSS URL for background images.
     *
     * @return string
     */
    public function css()
    {
        return 'url(' . $this->url() . ')';
    }

    /**
     * Return the image contents.
     *
     * @return string
     */
    public function data()
    {

        /**
         * @var HasVersion|CanPublish $this
         */
        return file_get_contents(public_path(
            $this
                ->setVersion(false)
                ->getCachePath()
        ));
    }

    /**
     * Return if a method is an alteration
     * method for Intervention.
     *
     * @param string $method
     *
     * @return bool
     */
    protected function isAlteration(string $method)
    {
        return in_array($method, [
            'blur',
            'brightness',
            'colorize',
            'resizeCanvas',
            'contrast',
            'copy',
            'crop',
            'fit',
            'flip',
            'gamma',
            'greyscale',
            'heighten',
            'insert',
            'interlace',
            'invert',
            'limitColors',
            'pixelate',
            'opacity',
            'resize',
            'rotate',
            'amount',
            'widen',
            'orientate',
            'text',
        ]);
    }

    /**
     * Map Intervention methods through alterations.
     *
     * @param string $method
     * @param array $parameters
     * @return $this
     */
    public function __call($method, array $parameters = [])
    {
        if ($this->isAlteration($method)) {
            return $this->addAlteration($method, $parameters);
        }

        if ($this->hasMacro(Str::snake($method))) {

            $macro = static::$macros[$method];

            if ($macro instanceof \Closure) {
                return call_user_func_array($macro->bindTo($this, static::class), $parameters);
            }

            return $macro(...$parameters);
        }

        $this->attributes[$method] = array_shift($parameters);

        return $this;
    }

    /**
     * Return string output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->img();
    }
}
