<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Value
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Value
{

    /**
     * Make a value from the parameters and entry.
     *
     * @param $parameters
     * @param $payload
     * @param array $payload
     * @return mixed|string
     */
    public static function make($parameters, $entry, $term = 'entry', $payload = [])
    {

        /**
         * Load the termed entry.
         */
        $payload[$term] = $entry;

        /*
         * If a flat value was sent in
         * then convert it to an array.
         */
        if (!is_array($parameters)) {
            $parameters = [
                'value' => $parameters,
            ];
        }

        $value = array_get($parameters, 'value');

        /*
         * If the value is a view path then return a view.
         */
        if ($view = array_get($parameters, 'view')) {
            return view($view, ['value' => $value, $term => $entry])->render();
        }

        /*
         * If the value uses a template then parse it.
         */
        if ($template = array_get($parameters, 'template')) {
            return (string) Template::render($template, ['value' => $value, $term => $entry]);
        }

        /*
         * If the entry is an instance of EntryInterface
         * then try getting the field value from the entry.
         */
        if ($entry->stream()->fields->has($value)) {
            $value = $entry->getFieldValue($value);
        }

        /*
         * Decorate the entry object before
         * sending to decorate so that data_get()
         * can get into the presenter methods.
         */
        $payload[$term] = $entry = Facades\Decorator::decorate($entry);

        /*
         * By default we can just pass the value through
         * the evaluator utility and be done with it.
         */
        $value = Facades\Evaluator::evaluate($value, $payload);

        /*
         * Lastly, parse the entry intro the string
         */
        if ($entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        /*
         * Parse the value with the entry.
         */
        if ($wrapper = array_get($parameters, 'wrapper')) {
            $value = app(Parser::class)->parse(
                $wrapper,
                ['value' => $value, $term => $entry]
            );
        }

        /*
         * Parse the value with the value too.
         */
        if (is_string($value)) {

            $value = app(Parser::class)->parse(
                $value,
                [
                    'value' => $value,
                    $term   => $entry,
                ]
            );

            $value = data_get([$term => $entry], $value, $value);
        }

        /*
         * If the value looks like a language
         * key then try translating it.
         */
        if (is_string($value) && str_is('*.*.*::*', $value)) {
            $value = trans($value);
        }

        /**
         * If the value is not explicitly marked 
         * safe then escape it automatically.
         */
        if (is_string($value) && array_get($parameters, 'is_safe') !== true) {
            $value = app(Purifier::class)->purify($value);
        }

        /*
         * If the value looks like a render-able
         * string then render it.
         */
        if (is_string($value) && str_contains($value, ['{{', '<?php'])) {
            $value = (string) Template::render($value, [$term => $entry]);
        }

        return $value;
    }
}
