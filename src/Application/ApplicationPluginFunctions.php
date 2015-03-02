<?php namespace Anomaly\Streams\Platform\Application;

/**
 * Class ApplicationPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationPluginFunctions
{

    /**
     * Return an environmental variable.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function env($key, $default = null)
    {
        return env($key, $default);
    }
}
