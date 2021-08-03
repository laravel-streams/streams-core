<?php

namespace Streams\Core\Image;

use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Intervention\Image\Constraint;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Prototype;
use Intervention\Image\Image as InterventionImage;

/**
 * Class Image
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
abstract class Image
{
    use Macroable;
    use Prototype;

    /**
     * Return the image asset URL.
     * 
     * @return string
     */
    abstract public function assetUrl();

    /**
     * Return if the image exists.
     * 
     * @return bool
     */
    abstract public function exists();

    /**
     * Return the image size.
     * 
     * return int
     */
    abstract public function size();

    /**
     * Return the last modified timestamp.
     * 
     * @return int
     */
    abstract public function lastModified();

    /**
     * Return the output image instance.
     *
     * @return Image
     */
    abstract protected function output();

    /**
     * Return an Intervention instance.
     *
     * @return InterventionImage
     */
    abstract protected function intervention();

    /**
     * Save the contents of the image.
     * 
     * @param InterventionImage $intervention
     */
    abstract public function save(InterventionImage $intervention);

    /**
     * Set the picture sources.
     *
     * @param array $sources
     * @return $this
     */
    public function sources(array $sources = [])
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Set the versioning option.
     *
     * @param $version
     * @return $this
     */
    public function version($version = true)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Return the image tag to an image.
     *
     * @param  array $attributes
     * @return string
     */
    public function img($alt = null, array $attributes = [])
    {
        $attributes = !$alt ? $attributes : [];

        $attributes = array_merge((array)$this->getPrototypeAttribute('attributes') ?: [], $attributes);

        if (!isset($attributes['src'])) {
            $attributes['src'] = $this->url();
        }

        if ($srcset = $this->srcsets) {
            $attributes['srcset'] = $srcset;
        }

        if ($alt) {
            $attributes['alt'] = $alt;
        }

        if (!isset($attributes['alt']) && Config::get('streams.core.auto_alt', true)) {
            $attributes['alt'] = $this->altTag();
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
            dd($source);
            return $source->source();
        }, $this->sources ?: []));

        $sources .= "\n" . $this->img($attributes);

        return "<picture>\n{$sources}\n</picture>";
    }

    /**
     * Return a favicon link.
     *
     * @param array $attributes
     * @return string
     */
    public function favicon(array $attributes = [])
    {
        $attributes = array_merge((array)$this->getPrototypeAttribute('attributes') ?: [], $attributes);

        if (!isset($attributes['href'])) {
            $attributes['href'] = $this->url();
        }

        if (!isset($attributes['sizes'])) {
            $attributes['sizes'] = '56x56';
        }

        $attributes['type'] = 'image/' . $this->extension();

        return '<link rel="icon" ' . HtmlFacade::attributes($attributes) . '>';
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
        if (Config::get('streams.core.version_images', true) && $this->version !== false) {
            $parameters['v'] = is_bool($this->version) ? $this->lastModified() : $this->version;
        }

        $parameters = array_filter($parameters) ? '?' . http_build_query($parameters) : null;

        return URL::asset($this->outputImage()->assetUrl($secure) . $parameters, $secure);
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

        return $this->version(false)->img($alt, $attributes);
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
        return file_get_contents($this->url());
    }

    /**
     * Return a source tag.
     *
     * @param array $attributes
     * @return string
     */
    public function source(array $attributes = [])
    {
        $attributes = array_merge($this->attributes(['srcset' => $this->srcset() ?: $this->url()]), $attributes);

        return '<source' . HtmlFacade::attributes($attributes) . '>';
    }

    /**
     * Set the filename.
     *
     * @param $filename
     * @return $this
     */
    public function rename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Return a guessed alt tag.
     * 
     * @return string
     */
    public function altTag()
    {
        $name = $this->filename ?: $this->getPrototypeAttribute('original');

        return ucwords(
            Str::humanize(
                basename($name, '.' . pathinfo($name, PATHINFO_EXTENSION)),
                '^a-zA-Z0-9'
            )
        );
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
     * Return if the image needs to be published.
     *
     * @param Image $output
     * @return bool
     */
    protected function shouldPublish(Image $output)
    {
        /**
         * If the image doesn't exist
         * we need to publish it.
         */
        if (!$output->exists()) {
            return true;
        }

        /**
         * If the image is outdated
         * we need to publish it.
         */
        if ($output->lastModified() < $this->lastModified()) {
            return true;
        }

        /**
         * If debug mode is enabled and request
         * is no-cache then we force publish.
         */
        if (Config::get('app.debug') && Request::isNoCache()) {
            return true;
        }

        return false;
    }

    /**
     * Publish an image to the publish directory.
     *
     * @param Image $output
     * @return void
     */
    protected function publish(Image $output)
    {
        $intervention = $this->intervention();

        if (function_exists('exif_read_data') && $intervention->exif('Orientation') > 1) {
            $intervention->orientate();
        }

        foreach ($this->alterations ?: [] as $method => $arguments) {
            if (is_array($arguments)) {
                call_user_func_array([$intervention, $method], $arguments);
            } else {
                call_user_func([$intervention, $method], $arguments);
            }
        }

        $output->save($intervention);
    }

    /**
     * Get the cached asset path of the image.
     *
     * @return Image
     */
    protected function outputImage()
    {
        $output = $this->output();

        if ($this->shouldPublish($output)) {
            $this->publish($output);
        }

        return $output;
    }

    /**
     * Return the generated filename.
     * 
     * @return string
     */
    protected function filename()
    {
        if ($this->filename) {
            return $this->filename;
        }

        if (!$this->alterations && !$this->quality) {
            return $this->getPrototypeAttribute('original');
        }

        return md5($this->getPrototypeAttribute('original') . json_encode([$this->alterations, $this->quality])) . '.' . $this->extension();
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
    protected function guessResizeArguments(array &$arguments)
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
     * Add an attribute
     *
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function addAttribute($name, $value)
    {
        $attributes = $this->getPrototypeAttribute('attributes', []);

        $attributes[$name] = $value;

        $this->setPrototypeAttribute('attributes', $attributes);

        return $this;
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
            'grayscale', // Mapped
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

            // Map gray to grey.
            if ($method == 'grayscale') {
                $method = 'greyscale';
            }

            return $this->addAlteration($method, $parameters);
        }

        if ($this->hasMacro(Str::snake($method))) {

            $macro = static::$macros[$method];

            if ($macro instanceof \Closure) {
                return call_user_func_array($macro->bindTo($this, static::class), $parameters);
            }

            return $macro(...$parameters);
        }

        $this->addAttribute($method, array_shift($parameters));

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
