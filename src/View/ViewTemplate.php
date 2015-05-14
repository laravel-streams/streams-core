<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\Collection;

/**
 * Class ViewTemplate
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View
 */
class ViewTemplate extends Collection
{

    /**
     * Set a value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->put($key, $value);

        return $this;
    }
}
