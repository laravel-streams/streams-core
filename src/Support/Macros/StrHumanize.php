<?php

namespace Streams\Core\Support\Macros;

class StrHumanize
{
    public function __invoke()
    {
        return function ($value, $separator = '_'): string {
            return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
        };
    }
}
