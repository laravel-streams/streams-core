<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Traits\CallableTrait;

class Addon
{

    use CallableTrait;

    protected $path = null;

    protected $type;

    protected $slug;

    public function getPath($path = null)
    {
        if (!$this->path) {

            $this->path = dirname(dirname((new \ReflectionClass($this))->getFileName()));
        }

        return $this->path . ($path ? '/' . ltrim($path, '/') : null);
    }

    public function isCore()
    {
        return str_contains($this->getPath(), 'core/addons');
    }

    public function getSlug()
    {
        if (!$this->slug) {

            $class = get_class($this);
            $parts = explode("\\", $class);

            $this->slug = snake_case($parts[count($parts) - 2]);
        }

        return $this->slug;
    }

    public function getType()
    {
        if (!$this->type) {

            $class = get_class($this);
            $parts = explode("\\", $class);

            $this->type = snake_case($parts[count($parts) - 3]);
        }

        return $this->type;
    }

    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }
}
