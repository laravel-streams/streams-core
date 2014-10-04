<?php namespace Streams\Platform\Addon;

use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Contract\PresenterInterface;

class Addon implements PresenterInterface
{
    use CallableTrait;

    protected $type = null;

    protected $slug = null;

    protected $path = null;

    public function isCore()
    {
        return str_contains($this->getPath(), base_path('core/'));
    }

    public function getPath($path = null)
    {
        return $this->path . ($path ? '/' . ltrim($path, '/') : null);
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $path;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }

    /**
     * Return a new addon presenter.
     *
     * @param $resource
     * @return mixed
     */
    public function newPresenter($resource)
    {
        $presenter = (new AddonClassResolver())->resolvePresenter($this->getType());

        return new $presenter($resource);
    }

    /**
     * Object to string method.
     * This is required of the presenter.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
