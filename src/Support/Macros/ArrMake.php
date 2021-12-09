<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Hydrator;

/**
 * @param mixed $target
 * @return mixed
 *
 */
class ArrMake
{
    public function __invoke()
    {
        return
            /**
             * @param mixed $target
             * @return mixed
             *
             */ function ($target) {
            if (Arr::accessible($target)) {
                foreach ($target as $item) {
                    if ($item && ! is_string($item)) {
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
        };
    }

}
