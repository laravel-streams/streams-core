<?php

if (!function_exists('humanize')) {
    /**
     * Return the humanized version of a string.
     *
     * @param null $string
     * @return string
     */
    function humanize($string = null)
    {
        return ucwords(str_replace('_', ' ', snake_case($string)));
    }
}

if (!function_exists('boolean')) {
    /**
     * Return the boolean evaluation of a string.
     *
     * @param null $string
     * @return mixed
     */
    function boolean($string = null)
    {
        return filter_var($string, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('evaluate')) {
    /**
     * Return the evaluated value of a value (ya, that's right).
     *
     * @param      $value
     * @param null $arguments
     * @return mixed|null
     */
    function evaluate($value, $arguments = [])
    {
        if ($value instanceof \Closure) {
            try {
                return call_user_func_array($value, $arguments);
            } catch (\Exception $e) {
                return null;
            }
        } elseif (is_array($value)) {
            foreach ($value as &$val) {
                $val = evaluate($val, $arguments);
            }
        }

        return $value;
    }
}

if (!function_exists('hashify')) {
    /**
     * Return a hash value from anything.
     *
     * @param $value
     * @return string
     */
    function hashify($value, $algorithm = 'md5')
    {
        ob_start();
        var_dump($value);
        $string = ob_get_clean();

        return hash($algorithm, $string);
    }
}

if (!function_exists('evaluate_key')) {
    /**
     * Return the evaluated value of an array key.
     *
     * @param $payload
     * @return string
     */
    function evaluate_key($array, $key, $default = null, $arguments = [])
    {
        $value = $default;

        if (isset($array[$key])) {
            $value = $array[$key];
        }

        return evaluate($value, $arguments);
    }
}