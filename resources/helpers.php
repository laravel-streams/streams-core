<?php

/**
 * Return the evaluated value of a value (ya, that's right).
 *
 * @param       $value
 * @param array $arguments
 * @return mixed|null
 */
function evaluate($value, array $arguments = [])
{
    if ($value instanceof \Closure) {

        try {

            return app()->call($value, $arguments);
        } catch (\Exception $e) {

            return null;
        }
    } elseif (is_array($value)) {

        foreach ($value as &$val) {

            $val = evaluate($val, $arguments);
        }
    }

    if (is_string($value) && str_contains($value, '{{')) {

        $value = view()->parse($value, $arguments)->render();
    }

    return $value;
}

/**
 * Determine if a string is translatable.
 *
 * This is helpful for defaulting and
 * cascading translatable strings.
 *
 * @param $string
 * @return bool
 */
function is_translatable($string)
{
    $translated = trans($string);

    return ($string !== $translated);
}

/**
 * Return the client's IP address.
 *
 * @return mixed
 */
function ip()
{
    return app('request')->ip();
}

/**
 * Determine if we have a lotto winner.
 *
 * @param  array $lottery [2, 100]
 * @return bool
 */
function hit(array $lottery = [2, 100])
{
    return mt_rand(1, $lottery[1]) <= $lottery[0];
}

/**
 * Return an array parsed into a string of attributes.
 *
 * @param array $attributes
 * @return string
 */
function attributes_string(array $attributes)
{
    return implode(
        ' ',
        array_map(
            function ($v, $k) {

                return $k . '=' . '"' . trans($v) . '"';
            },
            $attributes,
            array_keys($attributes)
        )
    );
}

/**
 * Get the path to the assets folder.
 *
 * @param  string $path
 * @return string
 */
function assets_path($path = '')
{
    return public_path('assets/' . APP_REF . ($path ? '/' . $path : $path));
}