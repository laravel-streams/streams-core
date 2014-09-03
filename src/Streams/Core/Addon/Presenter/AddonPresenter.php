<?php namespace Streams\Core\Addon\Presenter;


use Streams\Core\Support\Presenter;

class AddonPresenter extends Presenter
{
    /**
     * Return the name of the addon.
     *
     * @return mixed
     */
    public function name()
    {
        return \Lang::trans($this->resource->getType() . '.' . $this->resource->getSlug() . '::addon.name');
    }

    /**
     * Return the description of the addon.
     *
     * @return mixed
     */
    public function description()
    {
        return \Lang::trans($this->resource->getType() . '.' . $this->resource->getSlug() . '::addon.description');
    }

    /**
     * Return the slug.
     *
     * @return mixed
     */
    public function slug()
    {
        return $this->resource->getSlug();
    }
}
