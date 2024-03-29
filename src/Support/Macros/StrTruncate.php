<?php

namespace Streams\Core\Support\Macros;

class StrTruncate
{
    public function __invoke()
    {
        return function ($value, $limit = 100, $end = '...'): string {

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
