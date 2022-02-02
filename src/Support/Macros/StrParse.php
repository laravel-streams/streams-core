<?php

namespace Streams\Core\Support\Macros;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Streams\Core\Support\Facades\Hydrator;
use StringTemplate\Engine;

/**
  * @param mixed  $target
 * @param array $data
 * @return array|string|string[]
 *
 */
class StrParse
{
    public function __invoke()
    {
        return
            /**
                          * @param mixed  $target
             * @param array $data
             * @return array|string|string[]
             *
             */ function ($target, array $data = [])
        {

            if (!strpos($target, '}')) {
                return $target;
            }

            return app(Engine::class)->render($target, array_merge_recursive_distinct(
                App::make('streams.parser_data'),
                Arr::make($data),
                [
                    'app' => [
                        'locale' => App::getLocale(),
                    ]
                ]
            ));
        };
    }

}
