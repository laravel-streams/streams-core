<?php

namespace Streams\Core\Support\Macros;

class StrPurify
{
    public function __invoke()
    {
        return function ($value): string {
            
            $config = \HTMLPurifier_Config::createDefault();
            $purifier = new \HTMLPurifier($config);
            
            return $purifier->purify($value);
        };
    }
}
