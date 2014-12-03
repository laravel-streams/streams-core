<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

class ParseFilterInputCommandHandler
{

    public function handle(ParseFilterInputCommand $command)
    {
        $filters = $command->getFilters();

        foreach ($filters as $key => &$value) {

            $value = $this->parse($key, $value);
        }

        return array_values($filters);
    }

    protected function parse($key, $value)
    {
        /**
         * If the key is not the slug and the value is
         * a string then treat the string as both the
         * filter and the slug. This is OK as long as
         * there are not multiple instances of this
         * input using the same filter which is not likely.
         */
        if (is_numeric($key) and is_string($value)) {

            return [
                'slug'   => $value,
                'filter' => $value,
            ];
        }

        /**
         * If the key IS the slug and the value is a
         * string then use the key as the slug and the
         * value as the filter.
         */
        if (!is_numeric($key) and is_string($value)) {

            return [
                'slug'   => $key,
                'filter' => $value,
            ];
        }

        /**
         * If the key is a slug and the value is an
         * array without a slug then use the key for
         * the slug here.
         */
        if (is_array($value) and !isset($value['slug']) and !is_numeric($key)) {

            $value['slug'] = $key;
        }

        return $value;
    }
}
 