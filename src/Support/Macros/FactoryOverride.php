<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\View\View as ViewInterface;
use Streams\Core\View\ViewOverrides;

/**
 * @param $view
 * @param $override
 * @return ViewInterface
 */
class FactoryOverride
{
    public function __invoke()
    {
        return
            /**
             * @param $view
             * @param $override
             * @return ViewInterface
             */ function ($view, $override)
    {
        return app(ViewOverrides::class)->put($view, $override);
    };
    }

}
