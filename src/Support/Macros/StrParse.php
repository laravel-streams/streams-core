<?php

namespace Streams\Core\Support\Macros;

use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

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
             */
            function ($target, array $data = []) {

                if (!strpos($target, '}')) {
                    return $target;
                }

                return app(Engine::class)->render($target, array_replace_recursive(
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
