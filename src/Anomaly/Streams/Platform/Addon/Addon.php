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
     * This is set automatically.
     *
     * @var null
     */
    protected $path = null;

    /**
     * The addon type.
     * This is set automatically.
     *
     * @var
     */
    protected $type;

    /**
     * The addon slug.
     * This is set automatically.
     *
     * @var
     */
    protected $slug;

    /**
     * Get the lang string for a given key.
     *
     * @param $key
     * @return string
     */
    public function lang($key)
    {
        return "{$this->getType()}.{$this->getSlug()}::{$key}";
    }

    /**
     * Get the addon path. Optionally include an
     * additional path suffix.
     *
     * @param null $path
     * @return string
     */
    public function getPath($path = null)
    {
        if (!$this->path) {

            $this->path = dirname(dirname((new \ReflectionClass($this))->getFileName()));
        }

        return $this->path . ($path ? '/' . ltrim($path, '/') : null);
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
     * Get the addon slug.
     *
     * @return string
     */
    public function getSlug()
    {
        if (!$this->slug) {

            $class = get_class($this);
            $parts = explode("\\", $class);

            $this->slug = snake_case($parts[count($parts) - 2]);
        }

        return $this->slug;
    }

    /**
     * Get the addon type.
     *
     * @return string
     */
    public function getType()
    {
        if (!$this->type) {

            $class = get_class($this);
            $parts = explode("\\", $class);

            $this->type = snake_case($parts[count($parts) - 3]);
        }

        return $this->type;
    }

    /**
     * Get the addon abstract string.
     *
     * @return string
     */
    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
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
