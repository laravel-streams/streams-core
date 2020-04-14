<?php

namespace Anomaly\Streams\Platform\Traits;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Trait ProvidesArrayable
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesArrayable
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Arr::make(Hydrator::dehydrate($this));
    }
}
