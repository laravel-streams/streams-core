<?php

namespace Anomaly\Streams\Platform\Field\Value;

use Illuminate\Support\Arr;

/**
 * Class ArrValue
 * 
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ArrValue extends Value
{

    /**
     * Get an array value.
     *
     * @param string $key
     * @param mixed $default
     */
    public function get($key, $default = null)
    {
        return Arr::get($this->value, $key, $default);
    }

    /**
     * Pull an array value.
     *
     * @param string $key
     * @param mixed $default
     */
    public function pull($key, $default = null)
    {
        return Arr::pull($this->value, $key, $default);
    }
}
