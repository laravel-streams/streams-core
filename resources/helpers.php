<?php

if (!function_exists('slugify')) {
    /**
     * Return the slugified version of a string.
     *
     * @param        $string
     * @param string $separator
     * @return mixed|string
     */
    function slugify($string, $separator = '-')
    {
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace('/[\s-]+/', $separator, $string);
        $string = preg_replace("/[^0-9a-zA-Z-]/", '', $string);

        return $string;
    }
}

if (!function_exists('humanize')) {
    /**
     * Return the humanized version of a string.
     *
     * @param $string
     * @return string
     */
    function humanize($string)
    {
        return ucwords(str_replace('_', ' ', snake_case($string)));
    }
}

if (!function_exists('boolean')) {
    /**
     * Return the evaluated boolean value of a value.
     *
     * @param       $value
     * @param array $arguments
     * @return mixed
     */
    function boolean($value, $arguments = [])
    {
        return filter_var(evaluate($value, $arguments), FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('evaluate')) {
    /**
     * Return the evaluated value of a value (ya, that's right).
     *
     * @param       $value
     * @param array $arguments
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
     * @param        $value
     * @param string $algorithm
     * @return string
     */
    function hashify($value, $algorithm = 'md5')
    {
        ob_start();
        var_dump($value);

        return hash($algorithm, ob_get_clean());
    }
}

if (!function_exists('evaluate_key')) {
    /**
     * Return the evaluated value of an array key.
     * If no key exists return the default value.
     *
     * @param       $array
     * @param       $key
     * @param null  $default
     * @param array $arguments
     * @return mixed|null
     */
    function evaluate_key($array, $key, $default = null, $arguments = [])
    {
        return is_array($array) ? evaluate(key_value($array, $key, $default), $arguments) : $default;
    }
}

if (!function_exists('key_value')) {
    /**
     * Return the value of an array.
     * If no key exists return the default value.
     *
     * @param array $array
     * @param       $key
     * @param null  $default
     * @return null
     */
    function key_value(array $array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
}

if (!function_exists('memory_usage')) {
    /**
     * Return the current memory usage.
     *
     * @return string
     */
    function memory_usage()
    {
        $unit = array('b', 'kb', 'mb');

        $size = memory_get_usage(true);

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}

if (!function_exists('request_time')) {
    /**
     * Return the elapsed request time.
     *
     * @return mixed
     */
    function request_time()
    {
        return number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . ' s';
    }
}

if (!function_exists('merge')) {
    /**
     * Merge data into a string.
     *
     * @return string
     */
    function merge($string, $data)
    {
        if (!is_array($data)) {
            if (!$data instanceof \Illuminate\Contracts\Support\ArrayableInterface) {
                return null;
            } else {
                $data = $data->toArray();
            }
        }

        preg_match_all('/\{([a-z._)]*)\}/', $string, $matches);

        if (isset($matches[0])) {
            foreach ($matches[0] as $match) {
                $value = $data;
                $parts = explode('.', substr($match, 1, -1));

                foreach ($parts as $attribute) {
                    $value = evaluate_key($value, $attribute);
                }

                $string = str_replace($match, $value, $string);
            }
        }

        return $string;
    }
}

if (!function_exists('crud')) {
    /**
     * Shortcut to generate crud routes.
     */
    function crud($base, $controller)
    {
        // Help automate common CRUD routes.
        Route::any($base, $controller . '@index');
        Route::any($base . '/create', $controller . '@create');
        Route::any($base . '/edit/{id}', $controller . '@edit');
        Route::any($base . '/delete/{id}', $controller . '@delete');
    }
}
