<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\AddonPresenter;

/**
 * Class ModulePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModulePresenter extends AddonPresenter
{

    /**
     * Return the admin URL for the module.
     *
     * @return string
     */
    public function url()
    {
        return url('admin/' . $this->resource->getSlug());
    }
}
 