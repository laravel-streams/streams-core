<?php

namespace Streams\Core\Support\Macros;

/**
  * @param array $array
 * @return string
 */
class ArrExport
{
    public function __invoke()
    {
        return
            /**
                          * @param array $array
             * @return string
             */ function (array $array) {
            $export = var_export($array, true);
            $export = preg_replace("/^([ ]*)(.*)/m", '$1$1$2', $export);
            $array  = preg_split("/\r\n|\n|\r/", $export);
            $array  = preg_replace([ "/\s*array\s\($/", "/\)(,)?$/", "/\s=>\s$/" ], [ null, ']$1', ' => [' ], $array);
            $export = join(PHP_EOL, array_filter([ "[" ] + $array));

            return $export;
        };
    }

}
