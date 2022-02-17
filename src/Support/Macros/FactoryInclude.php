<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\View\ViewIncludes;
use Streams\Core\Support\Facades\Includes;

class FactoryInclude
{
    public function __invoke()
    {
        return function (string $slot, string $include): ViewIncludes {
            return Includes::include($slot, $include);
        };
    }
}
