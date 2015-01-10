<?php namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Html\HtmlBuilder;
use Intervention\Image\ImageManager;

/**
 * Class Image
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset
 */
class Image extends ImageManager
{

    /**
     * The publish flag.
     *
     * @var bool
     */
    protected $publish = false;

    /**
     * The publishable base directory.
     *
     * @var null
     */
    protected $directory = null;

    /**
     * Path hints by namespace.
     *
     * @var array
     */
    protected $namespaces = [];

    /**
     * The image object.
     *
     * @var null|string
     */
    protected $image = null;

    /**
     * Applied filters.
     *
     * @var array
     */
    protected $applied = [];

    /**
     * Available filters.
     *
     * @var array
     */
    protected $filters = [
        'blur',
        'brightness',
        'colorize',
        'contrast',
        'crop',
        'encode',
        'fit',
        'flip',
        'gamma',
        'greyscale',
        'heighten',
        'invert',
        'limitColors',
        'pixelate',
        'opacity',
        'resize',
        'rotate',
        'amount',
        'widen',
    ];

    /**
     * The HTML builder.
     *
     * @var \Illuminate\Html\HtmlBuilder
     */
    protected $html;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Image instance.
     *
     * @param HtmlBuilder $html
     * @param Application $application
     */
    public function __construct(HtmlBuilder $html, Application $application)
    {
        $this->html        = $html;
        $this->application = $application;
    }

    /**
     * An alias to create a new image instance.
     *
     * @param string $image
     * @return $this
     */
    public function make($image)
    {
        return $this->setImage($image);
    }

    /**
     * Publish an image to the publish directory.
     *
     * @param $path
     */
    protected function publish($path)
    {
        $image = parent::make($this->image);

        foreach ($this->applied as $method => $arguments) {
            if (in_array($method, $this->filters)) {
                $image = call_user_func_array([$image, $method], $arguments);
            }
        }

        app('files')->makeDirectory((new \SplFileInfo($path))->getPath(), 777, true, true);

        $image->save($this->directory . $path);
    }

    /**
     * Replace the namespace hint with it's path.
     *
     * @param  $path
     * @return string
     */
    protected function replaceNamespace($path)
    {
        if (str_contains($path, '::')) {
            list($namespace, $path) = explode('::', $path);

            if (isset($this->namespaces[$namespace]) && $location = $this->namespaces[$namespace]) {
                $path = $location . '/' . $path;
            }
        }

        return $path;
    }

    /**
     * Get the path of the image.
     *
     * @return string
     */
    protected function getPath()
    {
        $file = app('files');

        $filename = md5(var_export([$this->image, $this->applied], true)) . '.' . $this->getExtension($this->image);

        $path = 'assets/' . $this->application->getReference() . '/' . $filename;

        if (isset($_GET['_publish']) || !$file->exists($path)) {
            $this->publish($path);
        }

        return $path;
    }

    /**
     * Get the extension from a path.
     *
     * @param  $path
     * @return mixed
     */
    protected function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Apply a blur effect.
     *
     * @param  $pixels
     * @return $this
     */
    public function blur($pixels)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the brightness.
     *
     * @param  $level
     * @return $this
     */
    public function brightness($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Modify the color levels.
     *
     * @param  $red
     * @param  $green
     * @param  $blue
     * @return $this
     */
    public function colorize($red, $green, $blue)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the contrast.
     *
     * @param  $level
     * @return $this
     */
    public function contrast($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Crop the image.
     *
     * @param       $width
     * @param       $height
     * @param  null $x
     * @param  null $y
     * @return $this
     */
    public function crop($width, $height, $x = null, $y = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Fit the image to spec.
     *
     * @param       $width
     * @param  null $height
     * @return $this
     */
    public function fit($width, $height = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Flip the image.
     *
     * @param  $direction
     * @return $this
     */
    public function flip($direction)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the gamma level.
     *
     * @param  $level
     * @return $this
     */
    public function gamma($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Convert to greyscale.
     *
     * @return $this
     */
    public function greyscale()
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the height.
     *
     * @param  $height
     * @return $this
     */
    public function heighten($height)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Invert the colors.
     *
     * @return $this
     */
    public function invert()
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Limit colors used.
     *
     * @param       $count
     * @param  null $matte
     * @return $this
     */
    public function limitColors($count, $matte = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Pixelate the image.
     *
     * @param  $size
     * @return $this
     */
    public function pixelate($size)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the opacity.
     *
     * @param  $opacity
     * @return $this
     */
    public function opacity($opacity)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the quality.
     *
     * @param  $quality
     * @return $this
     */
    public function quality($quality)
    {
        return $this->applyFilter('encode', [$this->getExtension($this->image), $quality]);
    }

    /**
     * Resize the image.
     *
     * @param  $width
     * @param  $height
     * @return $this
     */
    public function resize($width, $height)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Rotate the image.
     *
     * @param       $angle
     * @param  null $background
     * @return $this
     */
    public function rotate($angle, $background = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Adjust the width.
     *
     * @param  $width
     * @return $this
     */
    public function widen($width)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    /**
     * Return the path to an image.
     *
     * @param  null $image
     * @return string
     */
    public function path($image = null)
    {
        if ($image) {
            $this->setImage($image);
        }

        $path = $this->getPath();

        $this->image   = null;
        $this->applied = [];

        return $path;
    }

    /**
     * Return the URL to an image.
     *
     * @param null $image
     * @return string
     */
    public function url($image = null)
    {
        return url($this->path($image));
    }

    /**
     * Return the image tag for an image.
     *
     * @param null  $image
     * @param null  $alt
     * @param array $attributes
     * @return string
     */
    public function image($image = null, $alt = null, $attributes = [])
    {
        return $this->html->image($this->url($image), $alt, $attributes);
    }

    /**
     * Add a filter to apply to the image.
     *
     * @param  $method
     * @param  $arguments
     * @return $this
     */
    protected function applyFilter($method, $arguments)
    {
        $this->applied[$method] = $arguments;

        return $this;
    }

    /**
     * Add a namespace path hint.
     *
     * @param  $binding
     * @param  $path
     * @return $this
     */
    public function addNamespace($binding, $path)
    {
        $this->namespaces[$binding] = $path;

        return $this;
    }

    /**
     * Set whether to force publishing.
     *
     * @param  $publish
     * @return $this
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Set the base publishable directory.
     *
     * @param  $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Set the image by it's path.
     *
     * @param  $path
     * @return $this
     */
    public function setImage($path)
    {
        $path = $this->replaceNamespace($path);

        $this->image = $path;

        return $this;
    }

    /**
     * Get supported filters.
     *
     * @return array
     */
    public function getSupportedFilters()
    {
        return $this->filters;
    }
}
