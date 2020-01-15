<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\HigherOrderCollectionProxy;

/**
 * Class Collection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Collection extends \Illuminate\Support\Collection
{

    /**
     * Map to get.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (method_exists($this, $method = camel_case($name))) {
            return call_user_func([$this, $method]);
        }

        return $this->get($name);
    }
}
