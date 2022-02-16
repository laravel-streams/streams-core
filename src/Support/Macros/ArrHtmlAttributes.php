<?php

namespace Streams\Core\Support\Macros;

class ArrHtmlAttributes
{
    public function __invoke()
    {
        return function (array $attributes): string {

            foreach ($attributes as $key => &$value) {

                if (is_bool($value) && $key !== 'value') {

                    $value = $value ? $key : null;

                    continue;
                }

                if (is_array($value) && $key === 'class') {
                    
                    $value = 'class="' . implode(' ', $value) . '"';

                    continue;
                }

                if (!is_numeric($key) && !is_null($value)) {
                    
                    $value = $key . '="' . e($value, false) . '"';

                    continue;
                }
            }

            $attributes = array_filter($attributes);

            return count($attributes) > 0 ? implode(' ', $attributes) : '';
        };
    }
}
