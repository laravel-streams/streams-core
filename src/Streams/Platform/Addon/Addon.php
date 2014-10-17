<?php namespace Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use Streams\Platform\Traits\CallableTrait;

class Addon
{
    use CallableTrait;

    protected $path = null;

    protected $type;

    protected $slug;

    protected $app;

    function __construct(Application $app)
    {
        $this->app = $app;

        $class = get_class($this);
        $parts = explode("\\", $class);

        $this->slug = snake_case($parts[count($parts) - 2]);
        $this->type = snake_case($parts[count($parts) - 3]);

        $this->path = dirname(dirname((new \ReflectionClass($this))->getFileName()));
    }

    public function getPath($path = null)
    {
        return $this->path . ($path ? '/' . ltrim($path, '/') : null);
    }

    public function isCore()
    {
        return str_contains($this->getPath(), 'core/addons');
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }
}
