<?php namespace Streams\Platform\Addon\Presenter;


use Streams\Platform\Support\Presenter;

class AddonPresenter extends Presenter
{
    /**
     * Return the name of the addon.
     *
     * @return mixed
     */
    public function name()
    {
        return trans($this->resource->getType() . '.' . $this->resource->getSlug() . '::addon.name');
    }

    /**
     * Return the description of the addon.
     *
     * @return mixed
     */
    public function description()
    {
        return trans($this->resource->getType() . '.' . $this->resource->getSlug() . '::addon.description');
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
