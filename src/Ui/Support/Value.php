<?php

namespace Anomaly\Streams\Platform\Ui\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Decorator;
use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

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

        $value = Arr::get($parameters, 'value');

        /*
         * If the value is a view path then return a view.
         */
        if ($view = Arr::get($parameters, 'view')) {
            return view($view, ['value' => $value, $term => $entry])->render();
        }

        /*
         * If the value uses a template then parse it.
         */
        if ($template = Arr::get($parameters, 'template')) {
            return (string) View::render($template, ['value' => $value, $term => $entry]);
        }

        /*
         * If the entry is an instance of EntryInterface
         * then try getting the field value from the entry.
         */
        if ($entry instanceof EntryInterface && $entry->stream()->fields->has($value)) {
            //$value = $entry->getFieldValue($value);
            $value = $entry->{$value};
            //if (is_array($value)) dd($value);
        }

        /*
         * Decorate the entry object before
         * sending to decorate so that data_get()
         * can get into the presenter methods.
         */
        $payload[$term] = $entry = Decorator::decorate($entry);

        /*
         * By default we can just pass the value through
         * the evaluator utility and be done with it.
         */
        $value = Evaluator::evaluate($value, $payload);

        /*
         * Lastly, parse the entry intro the string
         */
        if ($entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        /*
         * Parse the value with the entry.
         */
        if ($wrapper = Arr::get($parameters, 'wrapper')) {
            $value = Str::parse(
                $wrapper,
                ['value' => $value, $term => $entry]
            );
        }

        /*
         * Parse the value with the value too.
         */
        if (is_string($value)) {

            $value = Str::parse(
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
        if (is_string($value) && Str::is('*.*.*::*', $value)) {
            $value = trans($value);
        }

        /**
         * If the value is not explicitly marked 
         * safe then escape it automatically.
         */
        if (is_string($value) && Arr::get($parameters, 'is_safe') !== true) {
            $value = Str::purify($value);
        }

        /*
         * If the value looks like a render-able
         * string then render it.
         */
        if (is_string($value) && Str::contains($value, ['{{', '<?php'])) {
            $value = (string) View::parse($value, [$term => $entry]);
        }

        return $value;
    }
}
