<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;

class TranslatorTranslate
{
    public function __invoke()
    {
        return function (string|array $target): string|array {

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
