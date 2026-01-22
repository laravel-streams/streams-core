<?php

use Streams\Core\Image\Image;
use Streams\Core\Stream\Stream;
use Streams\Core\Criteria\Criteria;
use Illuminate\Support\Facades\Request;
use Streams\Core\Repository\Repository;
use Streams\Core\Support\Facades\Images;
use Streams\Core\Support\Facades\Streams;

if (! function_exists('response_time')) {

    /**
     * Get the response time in seconds.
     */
    function response_time(int $precision = 2): float
    {
        return (float) number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), $precision, '.', '');
    }
}

if (! function_exists('memory_usage')) {

    /**
     * Get the memory usage.
     */
    function memory_usage(int $precision = 2): string
    {
        $size = memory_get_usage(true);
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), $precision).' '.$unit[$i];
    }
}

if (! function_exists('stream')) {

    function stream(string $stream): Stream
    {
        return Streams::make($stream);
    }
}

if (! function_exists('entries')) {

    function entries(string $stream): Criteria
    {
        return Streams::entries($stream);
    }
}

if (! function_exists('repository')) {

    function repository(string $stream): Repository
    {
        return Streams::repository($stream);
    }
}

if (! function_exists('html_attributes')) {

    function html_attributes(array $attributes): string
    {
        if (empty($attributes)) {
            return '';
        }

        return ' '.implode(' ', array_map(
            function ($key, $value) {
                return $key.'="'.e($value).'"';
            },
            array_keys($attributes),
            $attributes
        ));
    }
}

if (! function_exists('image')) {

    function image(string $source): Image
    {
        return Images::make($source);
    }
}
