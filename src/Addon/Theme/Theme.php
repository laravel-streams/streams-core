<?php

namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Theme.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme
 */
class Theme extends Addon
{
    /**
     * Determines whether this is
     * an admin theme or not.
     *
     * @var bool
     */
    protected $admin = false;

    /**
     * Determines whether this is
     * the active theme or not.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Determines whether this is
     * the currently rendering theme
     * or not.
     *
     * @var bool
     */
    protected $current = false;

    /**
     * Get the admin flag.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Return the current flag.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * Set the current flag.
     *
     * @param $current
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get the module's presenter.
     *
     * @return ThemePresenter
     */
    public function getPresenter()
    {
        return app()->make('Anomaly\Streams\Platform\Addon\Theme\ThemePresenter', ['object' => $this]);
    }
}
