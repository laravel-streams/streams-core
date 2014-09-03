<?php namespace Streams\Core\Helper;

class ArrayHelper
{
    /**
     * Get a cache key from anything passed in at all.
     *
     * @param $payload
     * @return string
     */
    public function value($array, $name, $default = null, $arguments = [])
    {
        $value = $default;

        if (isset($array[$name])) {
            $value = $array[$name];
        }

        return \StreamsHelper::value($value, $arguments);
    }
}
