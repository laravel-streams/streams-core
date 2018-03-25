<?php namespace Anomaly\Streams\Platform\View;

use Illuminate\Support\Collection;

/**
 * Class ViewIncludes
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewIncludes extends Collection
{

    /**
     * Add an include to a slot.
     *
     * @param $slot
     * @param $include
     * @return $this
     */
    public function add($slot, $include)
    {
        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        /* @var Collection $includes */
        $includes = $this->get($slot);

        $includes->push($include);

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
        return implode(
            array_map(
                function ($include) {
                    return view($include)->render();
                },
                (array)$this->get($slot)
            ),
            "\n"
        );
    }
}
