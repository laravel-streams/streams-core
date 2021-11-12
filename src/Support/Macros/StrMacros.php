<?php

namespace Streams\Core\Support\Macros;

use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class StrMacros
{

    static public function humanize($value, $separator = '_'): string
    {
        return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
    }

    static public function parse($target, array $data = []): string
    {

        if (!strpos($target, '}')) {
            return $target;
        }

        return app(Engine::class)->render($target, array_merge_recursive(
            App::make('streams.parser_data'),
            Arr::make($data),
            [
                'app' => [
                    'locale' => App::getLocale(),
                ]
            ]
        ));
    }

    static public function truncate($value, $limit = 100, $end = '...'): string
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
    }

    public static function isSerialized(string $target, $strict = true): bool
    {
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

            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        }

        if (!$strict) {

            $semicolon = strpos($target, ';');
            $brace = strpos($target, '}');

            // Either ; or } must exist.
            if (false === $semicolon && false === $brace) {
                return false;
            }

            // But neither must be in the first 3 characters.
            if (false !== $semicolon && $semicolon < 3) {
                return false;
            }

            if (false !== $brace && $brace < 4) {
                return false;
            }
        }

        $token = $target[0];

        switch ($token) {
            case 's':
                if ($strict) {
                    if ('"' !== substr($target, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($target, '"')) {
                    return false;
                }
                // or else fall through
            case 'a':
            case 'O':
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $target);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $target);
        }
        
        return false;
    }
}
