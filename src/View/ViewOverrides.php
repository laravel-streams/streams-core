<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\Collection;

/**
 * Class ViewOverrides
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewOverrides extends Collection
{

    /**
     * Add an override.
     *
     * @param $view
     * @param $override
     * @return $this
     */
    public function add($view, $override)
    {
        $this->put(str_replace(['\\', '/'], '.', $view), str_replace(['\\', '/'], '.', $override));

        return $this;
    }

    /**
     * Force an override.
     *
     * @param $view
     * @param $override
     * @return $this
     * @deprecated since 1.6; Use add($view, $override)
     */
    public function force($view, $override)
    {
        $this->add($view, $override);

        return $this;
    }
}
