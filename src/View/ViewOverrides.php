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
     * When putting overrides replace "/" with "."
     * to match the way Laravel interprets views.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function put($key, $value)
    {
        $overrides = [];

        foreach ($value as $view => $override) {
            $overrides[str_replace('/', '.', $view)] = $override;
        }

        parent::put($key, $overrides);
    }
}
