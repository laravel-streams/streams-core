<?php

namespace Anomaly\Streams\Platform\Addon\Module;

use Illuminate\Support\Facades\Gate;
use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ModuleCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ModuleCollection extends AddonCollection
{

    /**
     * Undocumented variable
     *
     * @var null|string
     */
    protected $active = null;

    /**
     * Set the active module.
     *
     * @param string $active
     * @return $this
     */
    public function setActive(string $active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active module.
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Return the active module.
     *
     * @return Module|null
     */
    public function active()
    {
        if (!$active = $this->getActive()) {
            return null;
        }

        return app($active);
    }

    /**
     * Return accessible modules.
     *
     * @return ModuleCollection
     */
    public function accessible()
    {
        return $this->filter(function ($item) {

            // @todo we need to revisit and implement something here...
            return true;
        });
    }
}
