<?php

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

/**
 * Return the elapsed request time.
 *
 * @return mixed
 */
function request_time()
{
    return number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . ' s';
}

/**
 * Merge data into a string.
 *
 * @return string
 */
function merge($string, $data)
{
    if (!is_array($data)) {

        if (!$data instanceof \Streams\Platform\Contract\ArrayableInterface) {

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

/**
 * Shortcut to generate crud routes.
 *
 * @param $base
 * @param $controller
 */
function crud($base, $controller)
{
    // Help automate common CRUD routes.
    Route::any($base, $controller . '@index');
    Route::any($base . '/create', $controller . '@create');
    Route::any($base . '/edit/{id}', $controller . '@edit');
    Route::any($base . '/delete/{id?}', $controller . '@delete');
}

/**
 * Return the HTTP_REFERER or fallback.
 *
 * @return string
 */
function referer($fallback = null)
{
    if (!$fallback) {

        $fallback = url();

    }

    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $fallback;
}

/**
 * Return the streams package path.
 *
 * @param null $path
 * @return string
 */
function streams_path($path = null)
{
    return dirname(__DIR__) . ($path ? '/' . $path : null);
}

/**
 * Create a random hash string based on microtime.
 *
 * @param int $length
 * @return string
 */
function rand_string($length = 10)
{
    $chars  = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
    $max    = strlen($chars) - 1;
    $string = '';

    mt_srand((double)microtime() * 1000000);

    while (strlen($string) < $length) {

        $string .= $chars{mt_rand(0, $max)};

    }

    return $string;
}