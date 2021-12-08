<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\Support\Facades\Includes;
use Streams\Core\View\ViewIncludes;

/**
  * @param string $slot
 * @param string $include
 * @return ViewIncludes
 */
class FactoryInclude
{
    public function __invoke()
    {
        return
            /**
                          * @param string $slot
             * @param string $include
             * @return ViewIncludes
             */ function (string $slot, string $include) {
            return Includes::include($slot, $include);
        };
    }

}
