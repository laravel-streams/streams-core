<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;

class ArrMacros
{

    static public function make($target): array
    {
        if (Arr::accessible($target)) {
            foreach ($target as &$item) {
                if ($item && !is_string($item)) {
                    $item = Arr::make($item);
                }
            }
        }

        if (is_object($target) && $target instanceof Arrayable) {
            $target = $target->toArray();
        }

        if (is_object($target)) {
            $target = Hydrator::dehydrate($target);
        }

        return $target;
    }

    static public function undot(array $array): array
    {
        foreach ($array as $key => $value) {

            if (!strpos($key, '.')) {
                continue;
            }

            Arr::set($array, $key, $value);

            // Trash the old key.
            unset($array[$key]);
        }

        return $array;
    }

    static public function export(array $array): string
    {
        $export = var_export($array, true);
        $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
        $array = preg_split("/\r\n|\n|\r/", $export);
        $array = preg_replace(["/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/"], [null, ']$1', ' => ['], $array);
        $export = join(PHP_EOL, array_filter(["["] + $array));

        return $export;
    }

    static public function parse($target, array $payload = [])
    {
        $payload = Arr::make($payload);

        foreach ($target as &$value) {

            if (is_array($value)) {
                $value = Arr::parse($value, $payload);
            }

            if (is_string($value)) {
                $value = Str::parse($value, $payload);
            }
        }

        return $target;
    }
}
