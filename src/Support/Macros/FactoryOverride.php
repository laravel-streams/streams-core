<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\View\ViewOverrides;
use Streams\Core\Support\Facades\Overrides;

class FactoryOverride
{
    public function __invoke()
    {
        return function (string $view, string $override): ViewOverrides {
            return Overrides::put($view, $override);
        };
    }
}
