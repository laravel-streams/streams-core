<?php namespace Anomaly\Streams\Platform\Image;

use Anomaly\FilesModule\File\Contract\FileInterface;
use Anomaly\FilesModule\File\FilePresenter;
use Anomaly\Streams\Platform\Application\Application;
use Collective\Html\HtmlBuilder;
use Illuminate\Filesystem\Filesystem;
use Intervention\Image\ImageManager;
use League\Flysystem\File;

/**
 * Class Image
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Asset
 */
class Image
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
     * The file extension.
     *
     * @var null|string
     */
    protected $extension = null;

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
    protected $allowedMethods = [
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
     * The image manager.
     *
     * @var ImageManager
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
     * @param ImageManager $manager
     * @param Application  $application
     * @param ImagePaths   $paths
     */
    public function __construct(
        HtmlBuilder $html,
        Filesystem $files,
        ImageManager $manager,
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
     * @return $this
     */
    public function make($image)
    {
        $this->applied = [];

        return $this->setImage($image);
    }

    /**
     * Return the path to an image.
     *
     * @return string
     */
    public function path()
    {
        $path = $this->getCachePath();

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

        return $this->html->image($this->path(), $alt, $attributes);
    }

    /**
     * Return the image tag to an image.
     *
     * @param null  $alt
     * @param array $attributes
     * @return string
     */
    public function img($alt = null, $attributes = [])
    {
        return $this->image($alt, $attributes);
    }

    /**
     * Return the image response.
     *
     * @param null $format
     * @param int  $quality
     * @return String
     */
    public function encode($format = null, $quality = 100)
    {
        return $this->manager->make($this->getCachePath())->encode($format, $quality);
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
     * Get the cache path of the image.
     *
     * @return string
     */
    protected function getCachePath()
    {
        if (starts_with($this->getImage(), ['//', 'http'])) {
            return $this->getImage();
        }

        $filename = md5(var_export([md5($this->getImage()), $this->applied], true)) . '.' . $this->getExtension();

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

        if (is_string($this->image) && !str_is('*://*', $this->image) && filemtime($path) < filemtime($this->image)) {
            return true;
        }

        if (is_string($this->image) && str_is('*://*', $this->image) && filemtime($path) < app(
                'League\Flysystem\MountManager'
            )->getTimestamp($this->image)
        ) {
            return true;
        }

        if ($this->image instanceof File && filemtime($path) < $this->image->getTimestamp()) {
            return true;
        }

        if ($this->image instanceof FileInterface && filemtime($path) < $this->image->lastModified()->format('U')) {
            return true;
        }

        return false;
    }

    /**
     * Publish an image to the publish directory.
     *
     * @param $path
     */
    protected function publish($path)
    {
        $image = $this->makeImage();

        if (!$image) {
            return null;
        }

        foreach ($this->applied as $method => $arguments) {
            if (in_array($method, $this->getAllowedMethods())) {
                call_user_func_array([$image, $method], $arguments);
            }
        }

        $this->files->makeDirectory((new \SplFileInfo($path))->getPath(), 0777, true, true);

        $image->save($this->directory . $path);
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
     * Set the image.
     *
     * @param  $image
     * @return $this
     */
    public function setImage($image)
    {
        // Replace path prefixes.
        if (is_string($image) && str_contains($image, '::')) {

            $image = $this->paths->realPath($image);

            $this->setExtension(pathinfo($image, PATHINFO_EXTENSION));
        }

        if (is_string($image) && str_is('*://*', $image) && !starts_with($image, ['http', 'https'])) {

            $this->image = app('League\Flysystem\MountManager')->get($image);

            $this->setExtension(pathinfo($image, PATHINFO_EXTENSION));
        }

        if ($image instanceof FileInterface) {
            $this->setExtension($image->getExtension());
        }

        if ($image instanceof FilePresenter) {

            $image = $image->getObject();

            $this->setExtension($image->getExtension());
        }

        $this->image = $image;

        return $this;
    }

    /**
     * Get the image instance.
     *
     * @return \Intervention\Image\Image
     */
    public function getImage()
    {
        return $this->image;
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
     * Get the extension.
     *
     * @return null|string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set the extension.
     *
     * @param $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get the allowed methods.
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return $this->allowedMethods;
    }

    /**
     * Add a path by it's namespace hint.
     *
     * @param $namespace
     * @param $path
     * @return $this
     */
    public function addPath($namespace, $path)
    {
        $this->paths->addPath($namespace, $path);

        return $this;
    }

    /**
     * Make an image instance.
     *
     * @return \Intervention\Image\Image
     */
    protected function makeImage()
    {
        if ($this->image instanceof FileInterface) {
            return $this->manager
                ->make(app('League\Flysystem\MountManager')->read($this->image->location()))
                ->encode($this->getExtension());
        }

        if ($this->image instanceof File) {
            return $this->manager
                ->make($this->image->read())
                ->encode($this->getExtension());
        }

        if (is_string($this->image) && str_is('*://*', $this->image)) {
            return $this->manager
                ->make(app('League\Flysystem\MountManager')->read($this->image))
                ->encode($this->getExtension());
        }

        if (is_string($this->image) && file_exists($this->image)) {
            return $this->manager->make($this->image);
        }
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
        if (in_array($name, $this->getAllowedMethods())) {
            return $this->applyModification($name, $arguments);
        }

        if (!method_exists($this, $name)) {

            array_set($this->attributes, $name, array_shift($arguments));

            return $this;
        }

        return call_user_func_array([$this, $name], $arguments);
    }
}
