<?php namespace Streams\Platform\Addon;

use Streams\Platform\Traits\CallableTrait;
use Streams\Platform\Contract\PresenterInterface;

abstract class AddonAbstract implements PresenterInterface
{
    use CallableTrait;

    public function isCore()
    {
        return str_contains($this->getPath(), base_path('core/'));
    }

    public function getPath($path = null)
    {
        return dirname(dirname((new \ReflectionClass($this))->getFileName())) . ($path ? '/' . $path : null);
    }

    public function getSlug()
    {
        return basename($this->getPath());
    }

    public function getType()
    {
        return str_singular(basename(dirname($this->getPath())));
    }

    public function getAbstract()
    {
        return "streams.{$this->getType()}.{$this->getSlug()}";
    }

    /**
     * Return a new addon presenter.
     *
     * @param $resource
     * @return AddonPresenter
     */
    public function newPresenter($resource)
    {
        $presenter = (new AddonTypeClassResolver())->resolvePresenter($this->getType());

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
