<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Distribution
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Distribution
 */
class Distribution extends Addon
{

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The default standard theme.
     *
     * @var string
     */
    protected $standardTheme = 'anomaly.theme.streams';

    /**
     * The default admin theme.
     *
     * @var string
     */
    protected $adminTheme = 'anomaly.theme.streams';

    /**
     * Set the active flag.
     *
     * @param $active
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
     * Get the default admin theme.
     *
     * @return string
     */
    public function getAdminTheme()
    {
        return $this->adminTheme;
    }

    /**
     * Get the default standard theme.
     *
     * @return string
     */
    public function getStandardTheme()
    {
        return $this->standardTheme;
    }
}
