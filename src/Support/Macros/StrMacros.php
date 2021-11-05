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

        $default = App::has('streams.parser_data') ? App::make('streams.parser_data') : [];

        return app(Engine::class)->render($target, array_filter(array_merge($default, [
            'app' => [
                'locale' => App::getLocale(),
            ],
        ], Arr::make($data))));
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

    public static function isSerialized($data, $strict = true): bool
    {
        if (!is_string($data)) {
            return false;
        }

        $data = trim($data);

        if ($data == 'N;') {
            return true;
        }

        if (strlen($data) < 4) {
            return false;
        }

        if ($data[1] !== ':') {
            return false;
        }

        if ($strict) {

            $lastc = substr($data, -1);

            if (';' !== $lastc && '}' !== $lastc) {
                return false;
            }
        }

        if (!$strict) {

            $semicolon = strpos($data, ';');
            $brace = strpos($data, '}');

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

        $token = $data[0];

        switch ($token) {
            case 's':
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
                // or else fall through
            case 'a':
            case 'O':
                return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'b':
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }
        return false;
    }
}
