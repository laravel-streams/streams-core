<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Streams\Core\Support\Facades\Hydrator;

/**
  * @param mixed $target
 * @return mixed
 *
 */
class TranslatorTranslate
{
    public function __invoke()
    {
        return
            /**
                          * @param mixed $target
             * @return mixed
             *
             */ function ($target)
        {

            if (is_array($target) || $target instanceof Collection) {
                foreach ($target as &$value) {
                    $value = Lang::translate($value);
                }
            }

            if (is_string($target) && Str::contains($target, ['::', '.'])) {
                return __($target);
            }

            return $target;
        };
    }

}
