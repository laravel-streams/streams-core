<?php namespace Streams\Platform\Asset;

use Intervention\Image\ImageManager;

class Image extends ImageManager
{
    protected $publish = false;

    protected $directory = null;

    protected $namespaces = [];

    protected $image = null;

    protected $applied = [];

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

    public function make($path)
    {
        $instance = new self;

        $instance->setImage($path);

        return $instance;
    }

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

    protected function replaceNamespace($path)
    {
        if (str_contains($path, '::')) {

            list ($namespace, $path) = explode('::', $path);

            if (isset($this->namespaces[$namespace]) and $location = $this->namespaces[$namespace]) {
                $path = $location . '/' . $path;
            }

        }

        return $path;
    }

    protected function getPath()
    {
        $file = app('files');

        $filename = hashify([$this->image, $this->applied]) . '.' . $this->getExtension($this->image);

        $path = 'assets/' . APP_REF . '/' . $filename;

        if (isset($_GET['_publish']) or !$file->exists($path)) {
            $this->publish($path);
        }

        return $path;
    }

    protected function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    public function blur($pixels)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function brightness($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function colorize($red, $green, $blue)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function contrast($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function crop($width, $height, $x = null, $y = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function fit($width, $height = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function flip($direction)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function gamma($level)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function greyscale()
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function heighten($height)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function invert()
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function limitColors($count, $matte = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function pixelate($size)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function opacity($opacity)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function quality($quality)
    {
        return $this->applyFilter('encode', [$this->getExtension($this->image), $quality]);
    }

    public function resize($width, $height)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function rotate($angle, $background = null)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

    public function widen($width)
    {
        return $this->applyFilter(__FUNCTION__, func_get_args());
    }

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

    protected function applyFilter($method, $arguments)
    {
        $this->applied[$method] = $arguments;

        return $this;
    }

    public function addNamespace($binding, $path)
    {
        $this->namespaces[$binding] = $path;

        return $this;
    }

    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    public function setImage($path)
    {
        $path = $this->replaceNamespace($path);

        $this->image = $path;

        return $this;
    }

    public function getSupportedFilters()
    {
        return $this->filters;
    }
}
