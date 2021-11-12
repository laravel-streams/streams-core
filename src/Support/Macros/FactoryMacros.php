<?php

namespace Streams\Core\Support\Macros;

use Streams\Core\View\ViewIncludes;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Includes;

class FactoryMacros
{

    static function include(string $slot, string $include): ViewIncludes
    {
        return Includes::include($slot, $include);
    }

    static function includes($slot, array $payload = [])
    {
        return Includes::slot($slot)->map(function ($include) use ($payload) {
            return View::make($include, $payload)->render();
        })->implode("\n");
    }
}
