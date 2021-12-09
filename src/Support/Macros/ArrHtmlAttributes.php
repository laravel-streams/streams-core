<?php

namespace Streams\Core\Support\Macros;

use Collective\Html\HtmlFacade;

/**
 * @param array $attributes
 * @return string
 *
 */
class ArrHtmlAttributes
{
    public function __invoke()
    {
        return
            /**
             * @param array $attributes
             * @return string
             *
             */ function (array $attributes) {
            return HtmlFacade::attributes($attributes);
        };
    }

}
