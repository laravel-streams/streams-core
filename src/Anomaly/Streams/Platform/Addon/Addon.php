<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class Addon
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class Addon implements ArrayableInterface
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
     * @param $key
     * @return string
     */
    public function translate($key)
    {
        return "{$this->getType()}.{$this->getSlug()}::{$key}";
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
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return null
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'slug'        => $this->getSlug(),
            'path'        => $this->getPath(),
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }
}
