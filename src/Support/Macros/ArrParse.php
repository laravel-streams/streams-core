<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
  * @param mixed $target
 * @param array $payload
 * @return mixed
 *
 */
class ArrParse
{
    public function __invoke()
    {
        return
            /**
                          * @param mixed $target
             * @param array $payload
             * @return mixed
             *
             */ function ($target, array $payload = []) {
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
        };
    }

}
