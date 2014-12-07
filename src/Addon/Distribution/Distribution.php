<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Distribution
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class Distribution extends Addon
{

    /**
     * Get the default admin theme.
     *
     * @return string
     */
    public function getDefaultAdminTheme()
    {
        return 'streams';
    }

    /**
     * Get the default public theme.
     *
     * @return string
     */
    public function getDefaultPublicTheme()
    {
        return 'streams';
    }
}
