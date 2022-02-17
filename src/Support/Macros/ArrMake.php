<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;

class ArrMake
{
    public function __invoke()
    {
        return function ($target): array {
            
            if (is_object($target) && $target instanceof Arrayable) {
                $target = $target->toArray();
            }

            if (is_object($target)) {
                $target = Hydrator::dehydrate($target);
            }

            foreach ($target as &$item) {
                if ($item && !is_string($item)) {
                    $item = Arr::make($item);
                }
            }

            return $target;
        };
    }
}
