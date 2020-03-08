<?php

namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Theme\Theme;
use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ThemeCollection
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ThemeCollection extends AddonCollection
{
     /**
     * The active theme.
     *
     * @var null|string
     */
    protected $active = null;

    /**
     * Set the active theme.
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
     * Get the active theme.
     *
     * @return string
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Return the active theme.
     *
     * @return Theme|null
     */
    public function active()
    {
        if (!$active = $this->getActive()) {
            return null;
        }

        return app($active);
    }
}
