<?php namespace Streams\Core\Helper;

class CacheHelper
{
    /**
     * Get a cache key from anything passed in at all.
     *
     * @param $payload
     * @return string
     */
    public function key($payload)
    {
        ob_start();
        var_dump($payload);
        $string = ob_get_clean();

        return md5($string);
    }
}
