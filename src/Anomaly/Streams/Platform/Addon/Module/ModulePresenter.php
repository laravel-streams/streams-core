<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

class ModulePresenter extends AddonPresenter
{

    public function url()
    {
        return url('admin/' . $this->resource->getSlug());
    }
}
 