<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\Collection;

/**
 * Class ViewOverrides
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View
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
