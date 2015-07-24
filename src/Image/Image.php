<?php namespace Anomaly\Streams\Platform\Image;

use Anomaly\Streams\Platform\Application\Application;
use Collective\Html\HtmlBuilder;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use League\Flysystem\MountManager;

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
     * The image object.
     *
     * @var null|string
     */
    protected $image = null;

    /**
     * The default output method.
     *
     * @var string
     */
    protected $output = 'url';

    /**
     * The image attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Applied filters.
     *
     * @var array
     */
    protected $applied = [];

    /**
     * Allowed methods.
     *
     * @var array
     */
    protected $methods = [
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
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * Image path hints by namespace.
     *
     * @var ImagePaths
     */
    protected $paths;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The mount manager.
     *
     * @var MountManager
     */
    protected $manager;

    /**
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Image instance.
     *
     * @param HtmlBuilder  $html
     * @param Filesystem   $files
     * @param MountManager $manager
     * @param Application  $application
     * @param ImagePaths   $paths
     */
    public function __construct(
        HtmlBuilder $html,
        Filesystem $files,
        MountManager $manager,
        Application $application,
        ImagePaths $paths
    ) {
        $this->html        = $html;
        $this->files       = $files;
        $this->paths       = $paths;
        $this->manager     = $manager;
        $this->application = $application;
    }

    /**
     * Make a new image instance.
     *
     * @param mixed $image
     * @return Image
     */
    public function make($image)
    {
        $clone = clone($this);

        return $clone->setImage($image);
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
            if (in_array($method, $this->methods)) {
                $image = call_user_func_array([$image, $method], $arguments);
            }
        }

        $this->files->makeDirectory((new \SplFileInfo($path))->getPath(), 0777, true, true);

        $image->save($this->directory . $path);
    }

    /**
     * Get the path of the image.
     *
     * @return string
     */
    protected function getPath()
    {
        if (starts_with($this->image, ['http', '//'])) {
            return $this->image;
        }

        $filename = md5(var_export([$this->image, $this->applied], true)) . '.' . $this->getExtension($this->image);

        $path = 'assets/' . $this->application->getReference() . '/cache/' . $filename;

        if ($this->shouldPublish($path)) {
            $this->publish($path);
        }

        return $path;
    }

    /**
     * Determine if the image needs to be published
     *
     * @param $path
     * @return bool
     */
    private function shouldPublish($path)
    {
        if (!$this->files->exists($path)) {
            return true;
        }

        if (filemtime($path) < filemtime($this->image)) {
            return true;
        }

        return false;
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
     * Set an attribute value.
     *
     * @param $attribute
     * @param $value
     * @return $this
     */
    public function attr($attribute, $value)
    {
        array_set($this->attributes, $attribute, $value);

        return $this;
    }

    /**
     * Return the path to an image.
     *
     * @return string
     */
    public function path()
    {
        $path = $this->getPath();

        $this->image   = null;
        $this->applied = [];

        return $path;
    }

    /**
     * Return the URL to an image.
     *
     * @param array $parameters
     * @param null  $secure
     * @return string
     */
    public function url(array $parameters = [], $secure = null)
    {
        return url($this->path(), $parameters, $secure);
    }

    /**
     * Return the image tag to an image.
     *
     * @param null  $alt
     * @param array $attributes
     * @return string
     */
    public function image($alt = null, $attributes = [])
    {
        if (!$alt) {
            $alt = array_get($this->attributes, 'alt');
        }

        $attributes = array_merge($this->attributes, $attributes);

        return $this->html->image($this->getPath(), $alt, $attributes);
    }

    /**
     * Return the output.
     *
     * @return string
     */
    public function output()
    {
        return $this->{$this->output}();
    }

    /**
     * Add a modification to apply to the image.
     *
     * @param  $method
     * @param  $arguments
     * @return $this
     */
    protected function applyModification($method, $arguments)
    {
        $this->applied[$method] = $arguments;

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
        $path = $this->paths->realPath($path);

        if (
            config('app.debug')
            && !starts_with($path, ['http', '//'])
            && !is_file($path)
        ) {
            throw new \Exception("Image [{$path}] does not exist!");
        }

        $this->image = $path;

        return $this;
    }

    /**
     * Set the output mode.
     *
     * @param $output
     * @return $this
     */
    public function setOutput($output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Add an image path hint.
     *
     * @param $namespace
     * @param $path
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Return the output.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->output();
    }

    /**
     * If the method does not exist then
     * add an attribute and return.
     *
     * @param $name
     * @param $arguments
     * @return $this|mixed
     */
    function __call($name, $arguments)
    {
        if (in_array($name, $this->methods)) {
            return $this->applyModification($name, $arguments);
        }

        if (!method_exists($this, $name)) {

            array_set($this->attributes, $name, array_shift($arguments));

            return $this;
        }

        return call_user_func_array([$this, $name], $arguments);
    }
}
