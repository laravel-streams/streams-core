<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Support\Presenter;

class AddonPresenter extends Presenter
{

    /**
     * Return the name of the addon.
     *
     * @return mixed
     */
    public function name()
    {
        return trans($this->resource->getName());
    }

    /**
     * Return the description of the addon.
     *
     * @return mixed
     */
    public function description()
    {
        return trans($this->resource->getDescription());
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
