<?php

namespace Anomaly\Streams\Platform\Support\Traits;

/**
 * Trait HasWorkflows
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait HasWorkflows
{

    /**
     * Default callbacks through the provided object.
     *
     * @param mixed $object
     */
    public function passThrough($object) {
        
        $this->callback = function ($callback, $payload) use ($object) {
            $object->fire(implode('_', [
                $callback['workflow'],
                $callback['name']
            ]), $payload);
        };

        return $this;
    }
}
