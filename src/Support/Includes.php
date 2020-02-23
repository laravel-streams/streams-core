<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Collection;

/**
 * Class Includes
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Includes extends Collection
{

    /**
     * Add an include to a slot.
     *
     * @param $slot
     * @param $include
     * @return $this
     */
    public function include($slot, $include)
    {
        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        /* @var Collection $includes */
        $includes = $this->get($slot);

        $includes->put($include, $include);

        return $this;
    }

    /**
     * Render an include slot.
     *
     * @param $slot
     * @return string
     */
    public function render($slot)
    {
        if (!$includes = $this->get($slot)) {
            return null;
        }

        return implode(
            array_map(
                function ($include) {
                    return view($include)->render();
                },
                $includes->all()
            ),
            "\n"
        );
    }
}
