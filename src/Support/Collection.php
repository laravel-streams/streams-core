<?php

namespace Anomaly\Streams\Platform\Support;

use Anomaly\Streams\Platform\Traits\Hookable;
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

    use Hookable;

    /**
     * Map to get.
     *
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (in_array($name, static::$proxies)) {
            return new HigherOrderCollectionProxy($this, $name);
        }

        if ($this->hasHook($name)) {
            return $this->call($name, []);
        }

        if ($this->has($name)) {
            return $this->get($name);
        }

        return call_user_func([$this, camel_case($name)]);
    }

    /**
     * Map to get.
     *
     * @param string $method
     * @param array $parameters
     */
    public function __call($method, $parameters)
    {
        if (self::hasMacro($method)) {
            return parent::__call($method, $parameters);
        }

        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return $this->get($method);
    }
}
