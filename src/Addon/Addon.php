<?php namespace Anomaly\Streams\Platform\Addon;

use Laracasts\Commander\Events\EventGenerator;
use Robbo\Presenter\PresentableInterface;

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

    use EventGenerator;

    /**
     * The addon path.
     *
     * @var null
     */
    protected $path = null;

    /**
     * The addon type.
     *
     * @var
     */
    protected $type = null;

    /**
     * The addon slug.
     *
     * @var
     */
    protected $slug = null;

    /**
     * Translate a string in the addon's namespace.
     *
     * @param  $key
     * @return string
     */
    public function translate($key)
    {
        return "{$this->getType()}.{$this->getSlug()}::{$key}";
    }

    /**
     * Get the addon's presenter.
     *
     * @return AddonPresenter
     */
    public function getPresenter()
    {
        return new AddonPresenter($this);
    }

    /**
     * Get the core addon flag.
     *
     * @return bool
     */
    public function isCore()
    {
        return str_contains($this->getPath(), 'core/' . str_plural($this->getType()));
    }

    /**
     * Get the addon name string.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getType() . '.' . $this->getSlug() . '::addon.name';
    }

    /**
     * Get the addon description string.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getType() . '.' . $this->getSlug() . '::addon.description';
    }

    /**
     * Get the addon's IoC abstract.
     *
     * @return string
     */
    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }

    /**
     * Get a key prefixed by the addon's namespace.
     *
     * @param  null $key
     * @return string
     */
    public function getKey($key = null)
    {
        return "{$this->getType()}.{$this->getSlug()}" . ($key ? '::' . $key : $key);
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
     * Get the path appended by the provided path.
     *
     * @return string
     */
    public function getPath($path = null)
    {
        return $this->path . ($path ? '/' . $path : $path);
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
}
