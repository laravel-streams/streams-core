<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\View\View as ViewInterface;
use Streams\Core\View\ViewTemplate;

/**
 * @param string $template
 * @param array  $data
 * @param string $extension
 * @return ViewInterface
 */
class FactoryParse
{
    public function __invoke()
    {
        return
            /**
             * @param string $template
             * @param array  $data
             * @param string $extension
             * @return ViewInterface
             */ function (string $template, array $data = [], string $extension = 'blade.php') {
            return ViewTemplate::make($template, $data, $extension);
        };
    }

}
