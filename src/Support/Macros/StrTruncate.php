<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Streams\Core\Support\Facades\Hydrator;

/**
  * @param        $value
 * @param int    $limit
 * @param string $end
 * @return string
 */
class StrTruncate
{
    public function __invoke()
    {
        return
            /**
                          * @param        $value
             * @param int    $limit
             * @param string $end
             * @return string
             */ function($value, $limit = 100, $end = '...')
        {

            if (strlen($value) <= $limit) {
                return $value;
            }

            $parts  = preg_split('/([\s\n\r]+)/', $value, 0, PREG_SPLIT_DELIM_CAPTURE);
            $count  = count($parts);
            $length = 0;

            for ($last = 0; $last < $count; ++$last) {

                $length += strlen($parts[$last]);

                if ($length > $limit) {
                    break;
                }
            }

            return trim(implode(array_slice($parts, 0, $last))) . $end;
        };
    }

}
