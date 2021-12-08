<?php

namespace Streams\Core\Support\Macros;

use Parsedown;

/**
 * @param       $text
 * @return string
 */
class StrMarkdown
{
    public function __invoke()
    {
        return
            /**
             * @param       $text
             * @return string
             */ function ($text) {
            return Parsedown::instance()->parse($text);
        };
    }

}
