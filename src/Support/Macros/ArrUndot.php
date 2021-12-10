<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Arr;

/**
  * @param array $array
 * @return array
 */
class ArrUndot
{
    public function __invoke()
    {
        return
            /**
                          * @param array $array
             * @return array
             */ function (array $array) {
            foreach ($array as $key => $value) {

                if ( ! strpos($key, '.')) {
                    continue;
                }

                Arr::set($array, $key, $value);

                // Trash the old key.
                unset($array[ $key ]);
            }

            return $array;
        };
    }

}
