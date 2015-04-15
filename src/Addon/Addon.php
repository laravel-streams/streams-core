<?php namespace Anomaly\Streams\Platform\Addon;

use Robbo\Presenter\PresentableInterface;
use Robbo\Presenter\Presenter;

/**
 * Class Addon
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class Addon implements PresentableInterface
{

    /**
     * The addon path.
     *
     * @var string
     */
    protected $path = null;

    /**
     * The addon type.
     *
     * @var string
     */
    protected $type = null;

    /**
     * The addon slug.
     *
     * @var string
     */
    protected $slug = null;

    /**
     * The addon vendor.
     *
     * @var string
     */
    protected $vendor = null;

    /**
     * Get the addon's presenter.
     *
     * @return Presenter
     */
    public function getPresenter()
    {
        return new AddonPresenter($this);
    }

    /**
     * Return whether the addon is core or not.
     *
     * @return bool
     */
    public function isCore()
    {
        return str_contains($this->getPath(), 'core/' . $this->getVendor());
    }

    /**
     * Return whether the addon is shared or not.
     *
     * @return bool
     */
    public function isShared()
    {
        return str_contains($this->getPath(), 'addons/shared/' . $this->getVendor());
    }

    /**
     * Get the addon name string.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getNamespace('addon.name');
    }

    /**
     * Get the addon description string.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getNamespace('addon.description');
    }

    /**
     * Get a namespaced key string.
     *
     * @param  null $key
     * @return string
     */
    public function getNamespace($key = null)
    {
        return "{$this->getVendor()}.{$this->getType()}.{$this->getSlug()}" . ($key ? '::' . $key : $key);
    }

    /**
     * Return whether an addon has
     * config matching the key.
     *
     * @param string $key
     * @return boolean
     */
    public function hasConfig($key = '*')
    {
        return (config($this->getNamespace($key)));
    }

    /**
     * Get the composer json contents.
     *
     * @return mixed|null
     */
    public function getComposerJson()
    {
        $json = $this->getPath('composer.json');

        if (!file_exists($json)) {
            return null;
        }

        return json_decode(file_get_contents($json));
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the addon path.
     *
     * @return string
     */
    public function getPath($path = null)
    {
        return $this->path . ($path ? '/' . $path : $path);
    }

    /**
     * Return the app path.
     *
     * @param null $path
     */
    public function getAppPath($path = null)
    {
        return str_replace(base_path(), '', $this->getPath($path));
    }

    /**
     * Set the addon slug.
     *
     * @param  $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the addon slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the addon type.
     *
     * @param  $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the addon type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the vendor.
     *
     * @param $vendor
     * @return $this
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    /**
     * Get the vendor.
     *
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Get a property value from the object.
     *
     * @param $name
     * @return mixed
     */
    function __get($name)
    {
        $method = camel_case('get_' . $name);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        $method = camel_case('is_' . $name);

        if (method_exists($this, $method)) {
            return $this->{$method}();
        }

        return $this->{$name};
    }

    /**
     * Return whether a property is set or not.
     *
     * @param $name
     * @return bool
     */
    function __isset($name)
    {
        $method = camel_case('get_' . $name);

        if (method_exists($this, $method)) {
            return true;
        }

        $method = camel_case('is_' . $name);

        if (method_exists($this, $method)) {
            return true;
        }

        return isset($this->{$name});
    }
}
