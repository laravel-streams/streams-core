<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Includes;

/**
  * @param string $slot
 * @param array  $payload
 * @return string
 */
class FactoryIncludes
{
    public function __invoke()
    {
        return
            /**
                          * @param string $slot
             * @param array  $payload
             * @return string
             */ function ($slot, array $payload = []) {
            return Includes::slot($slot)->map(function ($include) use ($payload) {
                return View::make($include, $payload)->render();
            })->implode("\n");
        };
    }

}
