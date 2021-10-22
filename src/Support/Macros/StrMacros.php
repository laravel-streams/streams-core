<?php

namespace Streams\Core\Support\Macros;

use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class StrMacros
{

    static public function humanize($value, $separator = '_')
    {
        return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
    }

    static public function parse($target, array $data = [])
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

    static public function truncate($value, $limit = 100, $end = '...')
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
}
