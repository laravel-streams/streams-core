<?php

namespace Streams\Core\Suppport;

use Exception;
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
        if (!$include) {
            throw new Exception("[null] include in [{$slot}] is not allowed.");
        }

        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        /* @var Collection $includes */
        $includes = $this->get($slot);

        $includes->put($include, $include);

        return $this;
    }
}
