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
        list($namespace, $view) = explode('::', $view);

        $overrides = $this->get($namespace, []);

        $overrides[$namespace . '::' . $view] = $override;

        $this->put($namespace, $overrides);

        return $this;
    }

    /**
     * Force an override.
     *
     * @param $view
     * @param $override
     * @return $this
     */
    public function force($view, $override)
    {
        $overrides = $this->get('*', []);

        $overrides[$view] = $override;

        $this->put('*', $overrides);

        return $this;
    }

    /**
     * When putting overrides replace "/" with "."
     * to match the way Laravel interprets views.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function put($namespace, $overrides)
    {
        parent::put(
            $namespace,
            array_flip(
                array_map(
                    function ($view) {
                        return str_replace('/', '.', $view);
                    },
                    array_flip($overrides)
                )
            )
        );
    }
}
