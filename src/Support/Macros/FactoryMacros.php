<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class FactoryMacros
{

    static function include($slot, $include = null)
    {

        if (is_array($slot)) {

            foreach ($slot as $name => $includes) {
                /** @noinspection SuspiciousLoopInspection */
                foreach ($includes as $include) {
                    View::include($name, $include);
                }
            }

            return;
        }

        app(ViewIncludes::class)->include($slot, $include);
    }
    
    static function includes($slot, array $payload = []) {
        return app('includes')->get($slot, function () {
            return new Collection;
        })->map(function ($item) use ($payload) {
            return View::make($item, $payload)->render();
        })->implode("\n");
    }
}
