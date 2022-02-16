<?php

namespace Streams\Core\Support\Macros;

use StringTemplate\Engine;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class StrParse
{
    public function __construct(protected Engine $parser)
    {
    }

    public function __invoke()
    {
        $parser = $this->parser;

        return function ($target, array $data = []) use ($parser): string {

            if (!strpos($target, '}')) {
                return $target;
            }

            return $parser->render($target, array_replace_recursive(
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
