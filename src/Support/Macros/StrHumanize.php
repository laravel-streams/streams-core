<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Hydrator;

/**
  * @param        $value
 * @param string $separator
 * @return string
 */
class StrHumanize
{
    public function __invoke()
    {
        return
            /**
                          * @param        $value
             * @param string $separator
             * @return string
             */ function ($value, $separator = '_')
        {
            return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
        };
    }

}
