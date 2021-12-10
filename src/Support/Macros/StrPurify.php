<?php

namespace Streams\Core\Support\Macros;

use HTMLPurifier;

/**
 * @param string $html
 * @param null $config
 * @return string
 */
class StrPurify
{
    public function __invoke()
    {
        return
            /**
             * @param string $html
             * @param null $config
             * @return string
             */ function ($html, $config = null) {
            return HTMLPurifier::getInstance()->purify($html, $config);
        };
    }

}
