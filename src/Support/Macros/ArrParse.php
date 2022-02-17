<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ArrParse
{
    public function __invoke()
    {
        return function ($target, array $payload = []): array {

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
