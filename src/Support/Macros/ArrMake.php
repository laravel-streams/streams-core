<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;

class ArrMake
{
    public function __invoke()
    {
        return function ($target) {

            if (is_object($target) && $target instanceof Arrayable) {
                $target = $target->toArray();
            }

            if (is_object($target)) {
                $target = Hydrator::dehydrate($target);
            }

            if (
                is_string($target)
                || is_bool($target)
                || is_numeric($target)
            ) {
                return $target;
            }

            foreach ($target as &$item) {
                if ($item) {
                    $item = Arr::make($item);
                }
            }

            return $target;
        };
    }
}
