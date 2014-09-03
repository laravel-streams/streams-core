<?php namespace Streams\Core\Helper;

class StringHelper
{
    /**
     * Return a humanized version of a string.
     *
     * @param $string
     * @return string
     */
    public function humanize($string = null)
    {
        return ucwords(\Str::snake($string));
    }

    public function bool($string = null)
    {
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}
