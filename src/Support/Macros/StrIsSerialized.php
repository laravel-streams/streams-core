<?php

namespace Streams\Core\Support\Macros;

class StrIsSerialized
{
    public function __invoke()
    {
        return function (string $target, $strict = true): bool {

            $target = trim($target);

            if ($target == 'N;') {
                return true;
            }

            if (strlen($target) < 4) {
                return false;
            }

            if ($target[1] !== ':') {
                return false;
            }

            if ($strict) {

                $lastc = substr($target, -1);

                if ($lastc !== ';' && $lastc !== '}') {
                    return false;
                }
            }

            if (! $strict) {

                $semicolon = strpos($target, ';');
                $brace = strpos($target, '}');

                // Either ; or } must exist.
                if ($semicolon === false && $brace === false) {
                    return false;
                }

                // But neither must be in the first 3 characters.
                if ($semicolon !== false && $semicolon < 3) {
                    return false;
                }

                if ($brace !== false && $brace < 4) {
                    return false;
                }
            }

            $token = $target[0];

            switch ($token) {
                case 's':
                    if ($strict) {
                        if (substr($target, -2, 1) !== '"') {
                            return false;
                        }
                    } elseif (strpos($target, '"') === false) {
                        return false;
                    }
                    // or else fall through
                case 'a':
                case 'O':
                    return (bool) preg_match("/^{$token}:[0-9]+:/s", $target);
                case 'b':
                case 'i':
                case 'd':
                    $end = $strict ? '$' : '';

                    return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $target);
            }

            return false;
        };
    }
}
