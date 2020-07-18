<?php

namespace Anomaly\Streams\Platform\Image;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
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
     * Create a new class instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes = array_merge([
            'source' => null,
            'filename' => null,
            'original' => null,

            'alterations' => [],
            'attributes' => [],
            'soruces' => [],
            'srcsets' => [],
        ], $attributes);

        $this->fill($attributes);

        $this->buildProperties();
    }

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
     * @param  $arguments
     * @return $this
     */
    public function addAlteration($method, $arguments = [])
    {
        if ($method == 'resize') {
            $this->guessResizeArguments($arguments);
        }

        $attributes = $this->attributes;

        $attributes[$method] = $arguments;

        $this->attributes = $attributes;

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
            $arguments[] = function (Constraint $constraint) {
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
            return config('app.debug', false) ? $e->getMessage() : null;
        }

        if (config('streams.images.version') && $this->version !== false) {
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
    protected function outputPath($path)
    {

        /*
         * If the path is already public
         * and we don't have alterations
         * then just use it as it is.
         */
        if (
            Str::contains($this->source, [public_path(), 'public::'])
            && !$this->alterations
            && !$this->quality
        ) {
            return str_replace([public_path(), 'public::'], '', $this->source);
        }

        /*
         * If the path is already public
         * and we DO have alterations
         * then use the assets dir.
         */
        if (
            Str::contains($this->source, [public_path(), 'public::'])
            && ($this->hasAlterations() || $this->getQuality())
        ) {
            return str_replace([public_path(), 'public::'], '/assets/', $this->source);
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
        if (is_string($this->source) && Str::is('*://*', $this->source)) {

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
        $source = str_replace(base_path(), '', $path);

        /*
         * Build out path parts.
         */
        $filename    = basename($source);
        $directory   = ltrim(dirname($source), '/\\') . '/';

        if ($this->getAlterations() || $this->getQuality()) {
            $filename = md5(
                var_export([$source, $this->getAlterations()], true) . $this->getQuality()
            ) . '.' . $this->extension();
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
        $resolved = Images::path($path);

        if (!File::exists($path)) {
            return true;
        }

        if (is_string($this->source) && Str::startsWith($this->source, 'public::')) {
            return false;
        }

        if (is_string($this->source) && !Str::is('*://*', $this->source) && filemtime($path) < filemtime($resolved)) {
            return true;
        }

        if (
            is_string($this->source) && Str::is('*://*', $this->source) && filemtime($path) < app(
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
            return File::put(
                public_path($path),
                File::get(Images::path($this->source))
            );
        }

        /**
         * @var Intervention $image
         */
        if (!$image = $this->intervention()) {
            return false;
        }

        if (function_exists('exif_read_data') && $image->exif('Orientation') && $image->exif('Orientation') > 1) {
            //$this->addAlteration('orientate');
        }

        if (in_array($this->getExtension(), ['jpeg', 'jpg']) && config('streams.images.interlace')) {
            //$this->addAlteration('interlace');
        }

        if (!$this->getAlterations() && !$this->getQuality()) {
            return $image->save(public_path($path), $this->getQuality() ?: config('streams.images.quality', null));
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

        $image->save(public_path($path), $this->getQuality() ?: config('streams.images.quality', null));
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
        
        if (!$alt && !isset($attributes['alt']) && config('streams.images.auto_alt', true)) {
            $attributes['alt'] = Arr::get(
                $this->attributes,
                'alt',
                ucwords(
                    Str::humanize(
                        trim(basename(
                            $this->original,
                            pathinfo($this->original, PATHINFO_EXTENSION)
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
        $this->setQuality($quality);
        $this->setExtension($format);
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
        return URL::asset($this->getCachePath(), $parameters, $secure);
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
    public function isAlteration(string $method)
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
