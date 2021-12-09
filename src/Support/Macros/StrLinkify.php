<?php

namespace Streams\Core\Support\Macros;

use Misd\Linkify\Linkify;

/**
 * @param       $text
 * @param array $options
 * @return string
 */
class StrLinkify
{
    public function __invoke()
    {
        return
            /**
             * @param       $text
             * @param array $options
             * @return string
             */ function ($text, array $options = []) {
            return (new Linkify($options))->process($text);
        };
    }

}
