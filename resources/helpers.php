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