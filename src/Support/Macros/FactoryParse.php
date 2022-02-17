<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\View\View;
use Streams\Core\View\ViewTemplate;

class FactoryParse
{
    public function __invoke()
    {
        return function (string $template, array $data = [], string $extension = 'blade.php'): View {
            return ViewTemplate::make($template, $data, $extension);
        };
    }
}
