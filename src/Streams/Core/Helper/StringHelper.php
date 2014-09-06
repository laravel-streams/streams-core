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
        return ucwords(str_replace('_', ' ', snake_case($string)));
    }

    /**
     * Return the boolean evaluation of a string.
     * 
     * @param null $string
     * @return mixed
     */
    public function bool($string = null)
    {
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}
